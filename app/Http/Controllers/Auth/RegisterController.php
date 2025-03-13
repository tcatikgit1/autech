<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'myLayout' => 'blank',
            'blankPage' => true
        ];
    
        return view('auth.register', [
            'pageConfigs' => $pageConfigs
        ]);

        // return view('/auth/register', [
        //     'pageConfigs' => $pageConfigs
        // ]);
    }

    public function register(CreateUserRequest $request)
    {
        $validaciones = $request->validated();
        $validaciones['password'] = Hash::make($validaciones['password']);

        User::create([
            'nombre_completo' => $validaciones['nombre_completo'],
            'company_name' => $validaciones['company_name'],
            'email' => $validaciones['email'],
            'password' => $validaciones['password'],
            'cif' => $validaciones['cif'],
            'telefono' => $validaciones['telefono'],
        ]);

        return redirect('/');
    }
}
