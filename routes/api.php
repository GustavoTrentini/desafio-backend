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
    Route::post('/wallet/deposit', [WalletController::class, 'deposit']);

    // Rotas de Trasferências
    Route::post('/transfer', [TransferController::class, 'newTransfer'])->middleware(TransferMiddleware::class);
    Route::get('/transfer/send', [TransferController::class, 'send'])->middleware(TransferMiddleware::class);
    Route::get('/transfer/received', [TransferController::class, 'received']);
});
