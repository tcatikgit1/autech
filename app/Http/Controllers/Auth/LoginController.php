<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\APICallsController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

//    public function __construct()
//    {
//        $this->middleware('guest')->except('logout');
//    }

    public function login(Request $request)
    {
        $url = "/api/login";

//        $url = "/api/auth/login";

        $employee = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request->all())->getOriginalContent();


        //guardarToken y redigir al dashboard
        if(isset($employee) && array_key_exists('token', $employee)){
            session()->put('token', $employee['token']);
            session()->put('user', $employee['user']);
            session()->put('autonomo', $employee['autonomo']);
            session()->put('cliente', $employee['cliente']);
            return $this->sendLoginResponse($request);
        }else{
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);
        }


        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        return $this->sendFailedLoginResponse($request);

    }

    public function showLoginForm()
    {
      $pageConfigs = ['myLayout' => 'blank'];

      // Comprobamos si está logueado.
        $bearerToken = session()->get('token');
        $response = Http::withHeaders([
            'Authorization' => "Bearer $bearerToken", // Pasar el token de autenticación
            'Accept' => "application/json",
            'Content-Type' => "application/json",
        ]);

        $response = $response->post(config('app.GATEWAY_URL')."/api/auth/checkLogin");
        if ($response->successful() && $response['logged'] === true) {
            return redirect()->route('dashboard');
        }

      return view('auth.login', ['pageConfigs' => $pageConfigs]);
    }

//    protected function sendFailedLoginResponse(Request $request)
//    {
//        $error = [$this->username() => trans('auth.failed')];
//
//        // Comprobamos que el usuario no está activo
//        $user = User::query()->where($this->username(), $request->{$this->username()})
//            ->select('id','activo','email','password')
//            ->first();
//
//        if ($user && \Hash::check($request->password, $user->password)) {
//            if($user->activo != 1){
//                $error = [$this->username() => trans('auth.inactive')];
//            }
//        }else{
//            $error = [$this->username() => trans('auth.password')];
//        }
//
//        throw ValidationException::withMessages([
//            $this->username() => $error,
//        ]);
//    }

    // Redirige al usuario segun el rol
//    protected function sendLoginResponse(Request $request)
//    {
//        $request->session()->regenerate();
//
//        $this->clearLoginAttempts($request);
//
//        if ($response = $this->authenticated($request, $this->guard('web')->user())) {
//            return $response;
//        }
//
//        $userTipo = $this->guard()->user()->tipo;
//        return $request->wantsJson()
//            ? new JsonResponse([], 204)
//            : ($userTipo == 'user' ? \redirect('/') : \redirect('/dashboard'));
//    }


//    protected function credentials(Request $request)
//    {
//        return array_merge($request->only($this->username(), 'password'), ['activo' => 1]);
//    }
}
