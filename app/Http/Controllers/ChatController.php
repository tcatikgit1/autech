<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ChatController extends Controller
{
    public function index()
    {
        $pageConfigs = ['myLayout' => 'front'];
        return view('pages.chat.index', ['pageConfigs' => $pageConfigs]);
    }

    public static function routes()
    {
        return
            Route::controller(ChatController::class)->group(function () {
                // ------------------- RUTAS REDIRECCIONES DE AUTENTIFICACIÓN -------------------
                Route::get('/chat', 'index')->name('chat');
            });
    }
}
