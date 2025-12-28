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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Custom styles for dashboard template -->
        <style>
            /* Add any custom styles needed for the dashboard template here */
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased bg-child-bg-light">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-child-bg-light">
            <!-- Sidebar -->
            @include('layouts.dashboard.sidebar')

            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Header (Top Nav) -->
                @include('layouts.dashboard.header')

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-child-bg-light">
                    <div class="container mx-auto px-6 py-8">
                        <!-- Session Messages -->
                        @if (session('success'))
                            <div class="bg-child-success/10 border border-child-success text-child-success px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="bg-child-danger/10 border border-child-danger text-child-danger px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif
                        
                        <!-- Page Heading -->
                        @isset($header)
                            <h3 class="text-child-text-dark text-3xl font-medium">{{ $header }}</h3>
                        @endisset

                        <!-- Page Content -->
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        @stack('modals')
        @livewireScripts
    </body>
</html>