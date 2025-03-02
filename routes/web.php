<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rotas para todos os usuários autenticados
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas para administradores
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Adicione aqui as rotas exclusivas para administradores
    Route::get('/admin/panel', function () {
        return view('admin.panel');
    })->name('admin.panel');
    // exemplo de rota para gerenciar usuarios.
    Route::get('/admin/users', [\App\Http\Controllers\UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [\App\Http\Controllers\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy');
});

// Rotas para expedidores
Route::middleware(['auth', 'role:expedidor,admin'])->group(function () {
    // Adicione aqui as rotas exclusivas para expedidores
    Route::get('/expedidor/estoque', [\App\Http\Controllers\EstoqueController::class, 'index'])->name('expedidor.estoque');
    Route::get('/expedidor/estoque/{id}/baixar', [\App\Http\Controllers\EstoqueController::class, 'baixar'])->name('expedidor.baixar');
    Route::delete('/expedidor/estoque/{id}', [\App\Http\Controllers\EstoqueController::class, 'destroy'])->name('expedidor.destruir');
});

// Rotas para produção
Route::middleware(['auth', 'role:producao,admin'])->group(function () {
    // Adicione aqui as rotas exclusivas para produção
    Route::get('/producao/estoque', [\App\Http\Controllers\EstoqueController::class, 'index'])->name('producao.estoque');
    Route::get('/producao/estoque/create', [\App\Http\Controllers\EstoqueController::class, 'create'])->name('producao.create');
    Route::post('/producao/estoque', [\App\Http\Controllers\EstoqueController::class, 'store'])->name('producao.store');
    Route::get('/producao/estoque/{id}/edit', [\App\Http\Controllers\EstoqueController::class, 'edit'])->name('producao.edit');
    Route::put('/producao/estoque/{id}', [\App\Http\Controllers\EstoqueController::class, 'update'])->name('producao.update');
});

// Rotas para visitantes
Route::middleware(['auth', 'role:visitante,expedidor,producao,admin'])->group(function () {
    // Adicione aqui as rotas exclusivas para visitantes
    Route::get('/visitante/estoque', [\App\Http\Controllers\EstoqueController::class, 'index'])->name('visitante.estoque');
});

require __DIR__.'/auth.php';
