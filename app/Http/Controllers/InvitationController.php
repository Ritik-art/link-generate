<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        if ($user->role == 'SuperAdmin') {
            $invitations = DB::table('invitations')->get();
        } else {
            $invitations = DB::table('invitations')
                ->where('company_id', $user->company_id)
                ->get();
        }

        return view('invite', compact('invitations'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role == 'SuperAdmin') {
            $request->validate([
                'company_name' => 'required',
                'email' => 'required|email',
                'role' => 'required',
            ]);
        } else {
            $request->validate([
                'email' => 'required|email',
                'role' => 'required',
            ]);
        }

        $token = uniqid();
        $companyId = $user->company_id;

        if ($user->role == 'SuperAdmin') {
            $companyId = DB::table('companies')->insertGetId([
                'name' => $request->company_name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('invitations')->insert([
            'company_id' => $companyId,
            'email' => $request->email,
            'role' => $request->role,
            'token' => $token,
            'status' => 'Pending',
            'created_by' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $inviteLink = '/invite/accept/' . $token;

        return back()
            ->with('success', 'Invitation saved successfully.')
            ->with('invite_link', $inviteLink);
    }

    public function accept($token)
    {
        $invite = DB::table('invitations')->where('token', $token)->where('status', 'Pending')->first();

        if (!$invite) {
            abort(404);
        }

        return view('auth.register', ['inviteToken' => $token, 'inviteEmail' => $invite->email]);
    }

    public function acceptStore(Request $request, $token)
    {
        $invite = DB::table('invitations')->where('token', $token)->where('status', 'Pending')->first();

        if (!$invite) {
            abort(404);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        if ($request->email != $invite->email) {
            return back()->with('error', 'Email must match the invitation email.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => $invite->company_id,
            'role' => $invite->role,
        ]);

        DB::table('invitations')
            ->where('id', $invite->id)
            ->update([
                'status' => 'Accepted',
            'updated_at' => now(),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
