<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactoMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactoController extends Controller
{


    public function enviarCorreo(Request $request)
    {

            $request->validate([
                'email' => 'required|email',
                'nombre' => 'required|string|max:255',
                'mensaje' => 'required|string',
            ]);

            $data = [
                'email' => $request->email,
                'nombre' => $request->nombre,
                'mensaje' => $request->mensaje,
            ];

            Mail::to('destinatario@tuweb.com')->send(new ContactoMail($data));

    }
}
