<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body {
                    margin: 0;
                    font-family: Arial, sans-serif;
                    background: #ffffff;
                    color: #222222;
                }

                .auth-shell {
                    min-height: 100vh;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    padding: 24px;
                }

                .auth-brand {
                    margin-bottom: 12px;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .auth-brand svg {
                    width: 28px;
                    height: 28px;
                    display: block;
                }

                .auth-title {
                    font-weight: 700;
                    font-size: 18px;
                    color: #444444;
                }

                .auth-card {
                    width: 100%;
                    max-width: 520px;
                    background: #efefef;
                    border: 2px solid #555555;
                    padding: 22px;
                }

                .auth-card form > div {
                    margin-bottom: 16px;
                }

                .auth-card label {
                    display: block;
                    margin-bottom: 6px;
                    font-size: 14px;
                    font-weight: 600;
                    color: #444444;
                }

                .auth-card input[type="email"],
                .auth-card input[type="password"],
                .auth-card input[type="text"] {
                    width: 100%;
                    box-sizing: border-box;
                    padding: 10px 12px;
                    border: 1px solid #cbd5e1;
                    border-radius: 0;
                    font-size: 14px;
                    background: #fff;
                }

                .auth-card button {
                    background: #9fd0ff;
                    border: 2px solid #2a6adf;
                    color: #1f4f99;
                    border-radius: 0;
                    padding: 10px 16px;
                    cursor: pointer;
                    font-size: 14px;
                }

                .auth-card button:hover {
                    background: #c6e5ff;
                }

                .auth-card a {
                    color: #2a6adf;
                    text-decoration: none;
                }
            </style>
        @endif
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="auth-shell">
            <div class="auth-brand">
                <a href="/">
                    <x-application-logo class="fill-current text-gray-500 w-7 h-7" />
                </a>
                <div class="auth-title">Sembark URL Shortner</div>
            </div>

            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
