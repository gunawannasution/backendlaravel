<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Tempat setting middleware (misal: Sanctum, CORS, dll)
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // 1. Handling Jika Data Tidak Ditemukan (404 Model)
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan atau ID salah.',
                    'errors'  => null
                ], 404);
            }
        });

        // 2. Handling Jika Validasi Gagal (422)
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => $e->errors()
                ], 422);
            }
        });

        // 3. Handling HTTP Error Lainnya (404 Route, 403 Forbidden, dsb)
        $exceptions->render(function (HttpExceptionInterface $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'Terjadi kesalahan pada permintaan HTTP',
                    'errors'  => null
                ], $e->getStatusCode());
            }
        });

        // 4. Handling Error Umum / Server Error (500)
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Internal Server Error',
                    'errors'  => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        });
    })->create(); // Perbaikan: Menghapus kurung tutup ekstra
