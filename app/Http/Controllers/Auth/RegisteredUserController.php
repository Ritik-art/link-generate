<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $invite = null;

        if (session()->has('invite_token')) {
            $invite = DB::table('invitations')
                ->where('token', session('invite_token'))
                ->where('status', 'Pending')
                ->first();

            if (! $invite) {
                throw ValidationException::withMessages([
                    'email' => 'Invitation link is not valid.',
                ]);
            }
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
