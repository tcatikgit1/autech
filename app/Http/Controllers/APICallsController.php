<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class APICallsController extends Controller
{

    public static function callApi($method, $url, $arrayBody = [], $request = null){

        $response = Http::withHeaders( APICallsController::createHeadersConfig($request));

        // if(isset($request) && $request->file()){
        //     foreach ($request->file() as $key => $value) {
        //         $response = $response->attach($key, file_get_contents($value), $value->getClientOriginalName());
        //     }
        //     //$response = APICallsController::attachFiles($request, $response);
        // }

        // Si hay archivos en la solicitud, se adjuntan al cuerpo de la solicitud
        if (isset($request) && $request->file()) {
            foreach ($request->file() as $key => $file) {

                $response = $response->attach(
                    $key, 
                    file_get_contents($file->getRealPath()), 
                    $file->getClientOriginalName(), 
                    ['Content-Type' => $file->getMimeType()]
                );
            }

            // Pasar solo datos no relacionados con archivos como cuerpo
            $arrayBody = $request->except(array_keys($request->file())); // Remueve claves de archivos
        }
        $response = $response->$method($url, $arrayBody);

        return response()->json($response->json(), $response->status());
    }

    private static function attachFiles($request, &$response){

        $filesName = explode(',', $request->filesName);
        foreach ($request->file() as $key => $value) {
            $response = $response->attach($key, file_get_contents($value), $value->getClientOriginalName());
        }
        return $response;
    }
    private static function createHeadersConfig($request){
        $headersConfig = [
            'Accept' => "application/json",
//            'Content-Type' => "application/json",
//            'Content-Type'=> 'multipart/form-data'
        ];

        if(isset($request)){
            $headersConfig['Authorization'] = $request->header('Authorization');
            $bearerToken = session()->get('token');
            $headersConfig['Authorization'] = "Bearer $bearerToken";

            if ($request->file()) {
                // get Illuminate\Http\UploadedFile instance
                //dd($request->file());

                $image = $request->file('image');

                // post request with attachment
//                Http::
//                    ->post('example.com/v1/blog/store', $request->all());
            }
        }




        return $headersConfig;
    }
}
