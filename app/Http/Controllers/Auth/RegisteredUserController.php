<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $invite = null;
        $inviteToken = session('invite_token');

        if ($inviteToken) {
            $invite = DB::table('invitations')
                ->where('token', $inviteToken)
                ->where('status', 'Pending')
                ->first();

            if (! $invite) {
                throw ValidationException::withMessages([
                    'email' => 'Invitation link is not valid.',
                ]);
            }
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
        ]);

        if ($invite && strtolower($request->email) !== strtolower($invite->email)) {
            throw ValidationException::withMessages([
                'email' => 'Email must match the invitation email.',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => $invite ? $invite->company_id : null,
            'role' => $invite ? $invite->role : 'Member',
        ]);

        if ($invite) {
            DB::table('invitations')
                ->where('id', $invite->id)
                ->update([
                    'status' => 'Accepted',
                    'updated_at' => now(),
                ]);

            session()->forget(['invite_token', 'invite_email', 'invite_role', 'invite_company_id']);
        }

        return redirect('/login')->with('status', 'Registration complete. Please log in.');
    }
}
