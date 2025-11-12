<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-t">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased h-full">

        <div class="min-h-screen grid lg:grid-cols-2 h-full">

            <div class="flex flex-col justify-center items-center px-6 py-12 lg:px-8 bg-white">

                <div class="w-full max-w-md">
                    <div class="lg:hidden flex justify-center mb-6">
                        <a href="/">
                            <x-application-logo class="h-16 w-auto" />
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>

            <div class="hidden lg:flex flex-col justify-center items-center bg-gradient-to-br from-primary-600 to-indigo-800 text-white p-12">
                <a href="/" class="mb-6">
                    <x-application-logo class="h-24 w-auto" />
                </a>
                <h1 class="text-4xl font-bold tracking-tight text-center">
                    InvoicePro
                </h1>
                <p class="mt-4 text-lg text-primary-200 text-center max-w-sm">
                    Buat, kelola, dan kirim invoice profesional dalam hitungan detik.
                </p>
                </div>

        </div>
    </body>
</html>
