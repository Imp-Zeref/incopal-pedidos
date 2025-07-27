<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportacaoController;
use App\Livewire\PedidoCreate;
use App\Livewire\FreteCalculator;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/pedidos/criar', PedidoCreate::class)->name('pedidos.create');
    Route::get('/pedidos/index', [PedidoController::class, 'index'])->name('pedidos.index');
    
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');

    Route::get('/ferramentas/frete', FreteCalculator::class)->name('ferramentas.frete');

    Route::post('/pedidos/{pedido}/produtos', [PedidoController::class, 'addProduct'])->name('pedidos.produtos.store');
    Route::patch('/pedidos/{pedido}/status', [PedidoController::class, 'updateStatus'])->name('pedidos.status.update');
    Route::patch('/pedidos/{pedido}/cancel', [PedidoController::class, 'cancel'])->name('pedidos.cancel');
    Route::resource('pedidos', PedidoController::class)->except(['create', 'store']);

    Route::middleware('isAdmin')->group(function () {
        Route::get('/importar/produtos', [ImportacaoController::class, 'showProdutosForm'])->name('import.produtos.form');
        Route::post('/importar/produtos', [ImportacaoController::class, 'importProdutos'])->name('import.produtos.run');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});
