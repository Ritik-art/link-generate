<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
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
