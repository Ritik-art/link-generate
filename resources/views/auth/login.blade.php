@extends('layouts.guest')

@section('content')
    @if(session('status'))
        <p style="margin-bottom: 16px;">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
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
                autocomplete="current-password"
            >
            @error('password')
                <p style="color: red; margin-top: 6px;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" style="margin-top: 16px;">Login</button>
    </form>
@endsection
