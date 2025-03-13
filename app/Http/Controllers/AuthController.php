<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    public function registerA(Request $request)
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('auth.registerA', ['pageConfigs' => $pageConfigs, 'role' => 'autonomo']);
    }

    public function registerC(Request $request)
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('auth.registerC', ['pageConfigs' => $pageConfigs, 'role' => 'cliente']);
    }

    public function registerautonomus(Request $request)
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('auth.registerautonomus', ['pageConfigs' => $pageConfigs]);
    }

    public function registerclient(Request $request)
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('auth.registerclient', ['pageConfigs' => $pageConfigs]);
    }

    public function conditions(Request $request)
    {
        $pageConfigs = ['myLayout' => 'front'];
        return view('pages.home.conditions', ['pageConfigs' => $pageConfigs]);
    }

    public function verify(Request $request, $role)
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('auth.verifyphone', ['pageConfigs' => $pageConfigs, 'role' => $role]);
    }

    public function register(Request $request)
    {
        $role = $request->input('role');
        if ($role === 'cliente') {
            return redirect()->route('verify-phone', ['role' => 'cliente']);
        } elseif ($role === 'autonomo') {
            return redirect()->route('verify-phone', ['role' => 'autonomo']);
        }
        return redirect('/register');
    }

    public function registerRedirect(Request $request)
    {
        $role = $request->input('role');
        if ($role === 'cliente') {
            return redirect()->route('register-c');
        } elseif ($role === 'autonomo') {
            return redirect()->route('register-a');
        }
        return redirect('/register');
    }

    public function verifySubmit(Request $request)
    {
        $role = $request->input('role');
        if ($role === 'cliente') {
            return redirect()->route('register-clients');
        } elseif ($role === 'autonomo') {
            return redirect()->route('register-autonomus');
        }
        return redirect('/register');
    }

    public static function routes()
    {
        return
            Route::controller(AuthController::class)->group(function () {
                // ------------------- RUTAS REDIRECCIONES DE AUTENTIFICACIÓN -------------------
                Route::get('/registerA', 'registerA')->name('register-a');
                Route::get('/registerC', 'registerC')->name('register-c');
                Route::get('/registerautonomus', 'registerautonomus')->name('register-autonomus');
                Route::get('/registerclient', 'registerclient')->name('register-clients');
                Route::get('/conditions', 'conditions')->name('conditions');
                Route::get('/verifyphone/{role}', 'verify')->name('verify-phone');
                Route::post('/register', [AuthController::class, 'register'])->name('register');
                Route::post('/register-redirect', [AuthController::class, 'registerRedirect'])->name('register-redirect');
                Route::post('/verifyphone-submit', [AuthController::class, 'verifySubmit'])->name('verify-phone-submit');
            });
    }
}