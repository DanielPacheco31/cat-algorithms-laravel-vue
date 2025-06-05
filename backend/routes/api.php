<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlgorithmController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de prueba y algoritmos felinos
Route::get('/test', [AlgorithmController::class, 'test']);
Route::get('/info', [AlgorithmController::class, 'info']);
Route::post('/construir-casitas', [AlgorithmController::class, 'construirCasitas']);
Route::post('/longitud-siesta', [AlgorithmController::class, 'longitudSiesta']);
Route::post('/descifrar-maullido', [AlgorithmController::class, 'descifrarMaullido']);
