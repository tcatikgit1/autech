<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\ContactoController;



Route::get('/', [WebController::class, 'index'])->name('index');
Route::post('/enviar-correo', [ContactoController::class, 'enviarCorreo'])->name('enviar-correo');
