<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" id="app">
        <div class="min-h-screen bg-gray-100 relative">
            @include('layouts.navigation')

            <main>
                {{ $slot }}
            </main>
            @if (session('success'))
                <x-alert class="bg-blue-500" message="{{ session('success') }}"></x-alert>
            @endif
        </div>
    </body>
</html>
