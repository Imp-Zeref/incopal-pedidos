<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::patch('/pedidos/{pedido}/status', [PedidoController::class, 'updateStatus'])->name('pedidos.status.update');
    Route::resource('pedidos', PedidoController::class);
    Route::post('/pedidos/{pedido}/produtos', [PedidoController::class, 'addProduct'])->name('pedidos.produtos.store');
    Route::patch('/pedidos/{pedido}/cancel', [PedidoController::class, 'cancel'])->name('pedidos.cancel'); 
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});