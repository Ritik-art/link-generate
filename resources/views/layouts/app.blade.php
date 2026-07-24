<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body class="font-sans antialiased">
        <div class="app-shell">
            @include('layouts.navigation')

            @hasSection('header')
                <header class="app-header">
                    <div>
                        @yield('header')
                    </div>
                </header>
            @elseif(isset($header))
                <header class="app-header">
                    <div>
                        {{ $header }}
                    </div>
                </header>
            @endif

            @hasSection('content')
                <main class="app-main">
                    @yield('content')
                </main>
            @else
                <main class="app-main">
                    {{ $slot }}
                </main>
            @endif
        </div>
    </body>
</html>
