@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ isset($inviteToken) ? route('invite.accept.store', $inviteToken) : route('register') }}">
        @csrf

        @if(isset($inviteToken))
            <p style="margin-bottom: 16px;">You are registering from an invitation.</p>
        @endif

        <div>
            <label for="name">Name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
            >
            @error('name')
                <p style="color: red; margin-top: 6px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-top: 16px;">
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $inviteEmail ?? null) }}"
                required
                autocomplete="username"
            >
            @error('email')
                <p style="color: red; margin-top: 6px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-top: 16px;">
            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            >
            @error('password')
                <p style="color: red; margin-top: 6px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-top: 16px;">
            <label for="password_confirmation">Confirm Password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            >
            @error('password_confirmation')
                <p style="color: red; margin-top: 6px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-top: 16px;">
            <a href="{{ route('login') }}">Already registered?</a>
            <button type="submit" style="margin-left: 12px;">Register</button>
        </div>
    </form>
@endsection
