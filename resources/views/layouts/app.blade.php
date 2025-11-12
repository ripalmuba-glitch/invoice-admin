<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @media print {
                /* Sembunyikan semua elemen di body secara default */
                body * {
                    visibility: hidden;
                }

                /* Tampilkan HANYA #invoice-preview dan semua isinya */
                #invoice-preview, #invoice-preview * {
                    visibility: visible;
                }

                /* Posisikan #invoice-preview di paling atas halaman */
                #invoice-preview {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    margin: 0;
                    padding: 0;
                    border: none !important;
                    box-shadow: none !important;
                }

                /* Pastikan body dan html tidak punya padding/margin */
                body, html {
                    margin: 0;
                    padding: 0;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div>
                @include('layouts.navigation')
            </div>

            @if (isset($header))
                <header>
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
