<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Middleware\TransferMiddleware;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Rotas de usuários
    Route::get('/user', [UserController::class, 'getLoggedUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rotas de carteiras
    Route::get('/wallet', [WalletController::class, 'getWallet']);

    // Rotas de Trasferências
    Route::post('/transfer', [TransferController::class, 'newTransfer'])->middleware(TransferMiddleware::class);
});
