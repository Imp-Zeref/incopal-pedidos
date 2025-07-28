<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportacaoController;
use App\Http\Controllers\BlocoNotasController;
use App\Livewire\FreteCalculator;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/ferramentas/frete', FreteCalculator::class)->name('ferramentas.frete');

    Route::post('/bloco-notas/{blocoNota}/produtos', [BlocoNotasController::class, 'addProduct'])->name('bloco_notas.produtos.add');
    Route::delete('/bloco-notas/{blocoNota}/produtos/{produto}', [BlocoNotasController::class, 'removeProduct'])->name('bloco_notas.produtos.remove');
    
    Route::resource('bloco-notas', BlocoNotasController::class);

    Route::middleware('isAdmin')->group(function () {
        Route::get('/importar/produtos', [ImportacaoController::class, 'showProdutosForm'])->name('import.produtos.form');
        Route::post('/importar/produtos', [ImportacaoController::class, 'importProdutos'])->name('import.produtos.run');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});