<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body {
                    margin: 0;
                    font-family: Arial, sans-serif;
                    background: #fff;
                }

                .guest-page {
                    min-height: 100vh;
                    display: grid;
                    place-items: center;
                    padding: 24px;
                }

                .guest-box {
                    width: 100%;
                    max-width: 520px;
                    border: 1px solid #ccc;
                    background: #f7f7f7;
                    padding: 20px;
                }

                .guest-title {
                    margin-bottom: 16px;
                    font-size: 18px;
                    font-weight: bold;
                }

                .guest-box form > div {
                    margin-bottom: 14px;
                }

                .guest-box label {
                    display: block;
                    margin-bottom: 6px;
                }

                .guest-box input[type="email"],
                .guest-box input[type="password"],
                .guest-box input[type="text"] {
                    width: 100%;
                    box-sizing: border-box;
                    padding: 10px 12px;
                    border: 1px solid #cbd5e1;
                    background: #fff;
                }

                .guest-box button {
                    background: #ddd;
                    border: 1px solid #999;
                    padding: 10px 16px;
                    cursor: pointer;
                }

                .guest-box a {
                    color: #2563eb;
                }
            </style>
        @endif
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="guest-page">
            <div class="guest-box">
                <div class="guest-title">Sembark URL Shortner</div>

                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot }}
                @endif
            </div>
        </div>
    </body>
</html>
