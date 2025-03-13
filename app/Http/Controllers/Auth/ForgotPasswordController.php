<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Passwords\ForgotEmailRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('/auth/passwords/email');
    }

    public function sendResetLinkEmail(ForgotEmailRequest $request)
    {
        try{

            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );

            return ($response == Password::RESET_LINK_SENT)
                ? view('auth.passwords.reset')
                : $this->sendResetLinkFailedResponse($request, $response);
        }catch (\Exception $exception){
            return back()->withErrors('Se produjo un error al enviar el correo electrónico. Por favor, inténtelo de nuevo más tarde.');
        }

    }
}
