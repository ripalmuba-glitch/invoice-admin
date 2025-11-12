<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request; // <-- PASTIKAN IMPORT INI ADA

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // --- BLOK KODE YANG KITA TAMBAHKAN ---
        // Ini memberi tahu Laravel untuk mempercayai header
        // dari load balancer Railway (untuk HTTPS)
        $middleware->trustProxies(
            proxies: '*', // Percayai semua proxy
            headers: Request::HEADER_X_FORWARDED_FOR |
                     Request::HEADER_X_FORWARDED_HOST |
                     Request::HEADER_X_FORWARDED_PORT |
                     Request::HEADER_X_FORWARDED_PROTO |
                     Request::HEADER_X_FORWARDED_AWS_ELB
        );
        // --- AKHIR BLOK KODE ---

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
