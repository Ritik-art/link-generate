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

                .app-shell {
                    min-height: 100vh;
                    background: #ffffff;
                }

                .topbar {
                    background: #efefef;
                    border: 2px solid #f39c12;
                    border-left-width: 0;
                    border-right-width: 0;
                    padding: 10px 16px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 16px;
                    flex-wrap: wrap;
                }

                .brand {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    font-weight: 700;
                    font-size: 18px;
                }

                .brand a {
                    color: #111827;
                    text-decoration: none;
                }

                .nav-links {
                    display: flex;
                    align-items: center;
                    gap: 14px;
                    flex-wrap: wrap;
                }

                .nav-links a,
                .nav-links button {
                    font-size: 14px;
                    color: #222222;
                    background: transparent;
                    border: 0;
                    padding: 0;
                    cursor: pointer;
                    text-decoration: none;
                }

                .user-meta {
                    font-size: 13px;
                    color: #666666;
                }

                .app-header {
                    padding: 18px 24px 8px;
                }

                .app-main {
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 24px;
                }

                .app-card {
                    background: #f1f1f1;
                    border: 2px solid #555555;
                    padding: 16px;
                }

                .app-main a {
                    color: #2a6adf;
                    text-decoration: none;
                }

                .dashboard-grid {
                    display: grid;
                    grid-template-columns: 1.7fr 1fr;
                    gap: 18px;
                    align-items: start;
                }

                .panel {
                    background: #f2f2f2;
                    border: 2px solid #555555;
                    padding: 16px;
                }

                .panel-title {
                    margin: 0 0 12px;
                    color: #2a6adf;
                    font-size: 22px;
                    font-weight: 700;
                }

                .panel-title.red {
                    color: #ff4d4d;
                }

                .panel-title.green {
                    color: #44a047;
                }

                .panel-title.orange {
                    color: #ff8c00;
                }

                .btn {
                    display: inline-block;
                    background: #9fd0ff;
                    border: 2px solid #2a6adf;
                    color: #1f4f99;
                    padding: 6px 14px;
                    cursor: pointer;
                    font-size: 14px;
                    text-decoration: none;
                }

                .btn.small {
                    padding: 4px 10px;
                    font-size: 13px;
                }

                .table {
                    width: 100%;
                    border-collapse: collapse;
                    background: #ffffff;
                    border: 2px solid #555555;
                }

                .table th,
                .table td {
                    border: 1px solid #bdbdbd;
                    padding: 10px;
                    font-size: 13px;
                    text-align: left;
                }

                .table th {
                    background: #f7f7f7;
                }

                .card-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 16px;
                    flex-wrap: wrap;
                    margin-bottom: 14px;
                }

                .muted {
                    color: #666666;
                    font-size: 13px;
                }

                .stack > * + * {
                    margin-top: 12px;
                }

                .stats {
                    display: grid;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                    gap: 12px;
                    margin-bottom: 18px;
                }

                .stat {
                    background: #ffffff;
                    border: 2px solid #555555;
                    padding: 12px;
                }

                .stat .label {
                    font-size: 12px;
                    text-transform: uppercase;
                    color: #777777;
                    margin-bottom: 4px;
                }

                .stat .value {
                    font-size: 22px;
                    font-weight: 700;
                }

                @media (max-width: 900px) {
                    .dashboard-grid {
                        grid-template-columns: 1fr;
                    }

                    .stats {
                        grid-template-columns: 1fr;
                    }
                }
            </style>
        @endif
    </head>
    <body class="font-sans antialiased">
        <div class="app-shell">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="app-header">
                    <div>
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="app-main">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
