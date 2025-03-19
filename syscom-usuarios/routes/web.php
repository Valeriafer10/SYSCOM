<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

Route::get('/', [UsuarioController::class, 'index'])->name('home');

Route::resource('usuarios', UsuarioController::class);
Route::get('usuarios/{id}/contrato', [UsuarioController::class, 'verContrato'])->name('usuarios.contrato');