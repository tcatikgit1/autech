<?php

namespace App\Http\Controllers;

use App\Http\Controllers\APICallsController;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    // Redirección a perfil del usuario
    public function index(Request $request)
    {
        $tab = $request->query('tab', ''); // Si hacemos click en "Crear" en el navbar se recoge para poder redirigir a la pestaña correspondiente
        $modal = $request->query('modal', null); // Si hacemos click en "Crear" en el navbar se recoge para poder abrir el modal correspondiente
        return view('/pages/profile/index', compact('tab', 'modal'));
    }

    // ------------------- FUNCIONES VISTAS -------------------

    // Funcion que devuelve las vistas con los datos del usuario para la pagina de user-panel
    public function getDashboardView(Request $request)
    {
        $user_info = $this->getDashboard($request);
        $aside = view('pages.profile.profile-aside', compact('user_info'))->render();
        $content = view('pages.profile.profile-content', compact('user_info'))->render();

        return response()->json([
            'aside' => $aside,
            'content' => $content,
        ]);
    }

    // Funcion que devuelve las vistas con el historial de pagos del usuario para la pagina de user-panel
    public function getHistoryPaymentView(Request $request)
    {
        $payment_history = $this->getPaymentHistory($request, true);
        $payment_history = $payment_history["transacciones"];
        $payment_history = is_null($payment_history) ? [] : $payment_history;
        $content = view('pages.profile.profile-payment-history-content', compact('payment_history'))->render();
        return response()->json([
            'content' => $content,
        ]);
    }

    // Funcion que devuelve la vista de los favoritos del usuario en el panel de usuario
    public function getFavoritesView(Request $request)
    {
        $favoritos = $this->getFavorites($request, true);

        $anuncios = $favoritos['anuncios'];
        $autonomos = $favoritos['autonomos'];

        $anuncios = is_null($anuncios) ? [] : $anuncios;
        $autonomos = is_null($autonomos) ? [] : $autonomos;

        return view('pages.profile.profile-my-favs-content', compact('anuncios', 'autonomos'));
    }

    // Funcion que devuelve la vista de los paquetes de promocion del usuario en el panel de usuario
    public function getMyPromotionsView(Request $request)
    {
        $myPromotions = $this->getMyPromotions($request, true);
        $myPromotions = $myPromotions['data'];
        $myPromotions = is_null($myPromotions) ? [] : $myPromotions;
        $content = view('pages.profile.profile-my-promotions-content', compact('myPromotions'))->render();
        return response()->json([
            'content' => $content,
        ]);
    }

    // Funcion que devuelve la vista de los paquetes de promocion disponibles y los anuncios del usuario, para su adquisicion segun el tipo.
    public function getAdvPacksView(Request $request)
    {
        $type = $request->type;

        $myAdvertisements = null;
        if($type == 'anuncios') {
            $myAdvertisements = $this->gerMyAdvertisements($request)->getOriginalContent()['anuncios'];
        };

        $advPacks = $this->getAdvPacks($request, true);
        $advPacks = $advPacks['data'];
        $advPacks = is_null($advPacks) ? [] : $advPacks;
        $content = view('pages.profile.profile-promotions-packs', compact('advPacks', 'type', 'myAdvertisements'))->render();
        return response()->json([
            'view' => $content
        ]);
    }

    // ------------------- FUNCIONES API -------------------

    // Funcion que obtiene losdatos del usuario en el panel de usuario
    public function getDashboard(Request $request)
    {
        $userType = session()->get('user')['tipo'];
        $request->header('Authorization', 'Bearer ' . session()->get('token'));   
        $url = "/api/".$userType."/dashboard";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request, $request);
        $original_response = $response->getOriginalContent();
        return $original_response;
    }

    // Funcion que obtiene informacion adicional para el panel de usuario (habilidades generales, profesiones, tipos de autonomo)
    public function generalData(Request $request)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/userpanel/get-data-perfil";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request, $request);
        $responseOriginal = $response->getOriginalContent();
        return $responseOriginal;
    }

    // funcion que envia los datos del formulario de perfil
    public function storeProfileData(Request $request)
    {
        $userType = session()->get('user')['tipo'];
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/".$userType."/dashboard/update/".session()->get('user')['_id'];
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request, $request);
        if($response->status() == 200) {
            $this->updateSessionData($response->getOriginalContent());
        }
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function changeEmail(Request $request)
    {
        $userType = session()->get('user')['tipo'];
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/".$userType."/dashboard/change-email";
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request, $request);
        if($response->status() == 200) {
            session()->put('user.email', $request->new_email);
            session()->put('cliente.email', $request->new_email);
        }
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function changePassword(Request $request)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/userpanel/change-password";
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request, $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function deleteAccount(Request $request)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/userpanel/delete-account";
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request, $request);
        if($response->status() == 200) {
            Auth::logout(); // Cerramos la sesión del usuario
            Session::flush(); // Destruimos toda la sesión
        }
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function getPaymentHistory(Request $request, $forView = false)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/transacciones/get";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request, $request);
        if ($forView) return $response->getOriginalContent();
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function changeDataVisibility(Request $request)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $userType = session()->get('user')['tipo'];
        $profileId = $userType == 'autonomo' ? session()->get('autonomo')['_id'] : session()->get('cliente')['_id'];
        $url = "/api/" . $userType . "/dashboard/change-data-visibility/" . $profileId;
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request, $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function storeAdvertisement(Request $request)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $userType = session()->get('user')['tipo'];
        if(isset($request->anuncioId) && !is_null($request->anuncioId)) {
            $url = "/api/". $userType . "/anuncios/update/". $request->anuncioId; // URL para editar anuncio
        } else {
            $url = "/api/". $userType . "/anuncios/store"; // URL para crear anuncio
        }
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request, $request);

        $successLangCode = null;
        if (isset($response->getOriginalContent()['successLangCode'])) {
            $successLangCode = $response->getOriginalContent()['successLangCode'];
        }

        // Si la respuesta es correcta, devolvemos el anuncio y la vista del card
        if ($successLangCode == "advCreateCorrectly" || $successLangCode == "advUpdateCorrectly") { 
            $anuncio = $response->getOriginalContent()['anuncio'];
            $anuncioCardView = view('_partials.cards.anuncio-card-panel-usuario', compact('anuncio'))->render();
            return response()->json([
                'success' => true,
                'anuncio' => $anuncio,
                'anuncioCardView' => $anuncioCardView,
                'successLangCode' => $successLangCode,
            ], $response->status());
        }
        
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function deleteAdvertisement(Request $request, $id)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $userType = session()->get('user')['tipo'];
        $url = "/api/". $userType . "/anuncios/delete/" . $id;
        $response = APICallsController::callApi('delete', config('app.GATEWAY_URL') . $url, $request, $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function getAdvertisement(Request $request)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $userType = session()->get('user')['tipo'];
        $url = "/api/". $userType . "/anuncios/get-anuncio/" . $request->id;
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request, $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function renewalAvertisement(Request $request, $id)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $userType = session()->get('user')['tipo'];
        $url = "/api/". $userType . "/anuncios/renovar-anuncio/" . $id;
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request, $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function getFavorites(Request $request, $forView = false)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $userId = session()->get('cliente')['_id'];
        $url = "/api/cliente/likes/get/" . $userId;
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request, $request);
        if ($forView) return $response->getOriginalContent();
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function becomeAutonomus(Request $request)
    {   
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/cliente/dashboard/convertirse-autonomo";
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request, $request);
        if($response->status() == 200) {
            $this->updateSessionData($response->getOriginalContent());
        }
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function sendAutonomusData(Request $request)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/autonomo/dashboard/send-datos-autonomo";
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request, $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }
    
    public function getRechazosAutonomus(Request $request)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/autonomo/dashboard/get-rechazos";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request, $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function getMyPromotions(Request $request, $forView = false)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/autonomo/dashboard/get-my-advs";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request, $request);
        if ($forView) return $response->getOriginalContent();
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function getAdvPacks(Request $request, $forView = false)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/adv/get-advs-packs";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request, $request);
        if ($forView) return $response->getOriginalContent();
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function gerMyAdvertisements(Request $request)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $userType = session()->get('user')['tipo'];
        $profileId = $userType == 'autonomo' ? session()->get('autonomo')['_id'] : session()->get('cliente')['_id'];
        $url = "/api/".$userType."/anuncios/get-anuncios/".$profileId;
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request, $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function adquirirPaquetePromocion(Request $request)
    {
        $userId = session()->get('user')['_id'];
        $request['user_id'] = $userId;

        // llamar a checkAdvPack para comprobar que el paquete está disponible
        $response = $this->checkAdvPack($request);

        // Si la respuesta no es satisfactoria, devolverla al frontend sin continuar
        if ($response->status() !== 200) {
            return response()->json($response->getOriginalContent(), $response->status());
        }

        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/transacciones/pay";
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request, $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    // Petición que comprobará que el paquete que se va a adquirir está disponible en el momento de pulsar el botón de “Pagar” y devolverá el importe del mismo
    public function checkAdvPack($request)
    {
        $request->header('Authorization', 'Bearer ' . session()->get('token'));
        $url = "/api/transacciones/check-adv-pack/".$request->paquete_id;
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request, $request);
        return $response;
        // return response()->json($response->getOriginalContent(), $response->status());
    }

    // ------------------- EXTRA -------------------

    private function updateSessionData(array $data)
    {
        session()->put('user', $data['user'] ?? session()->get('user'));
        session()->put('autonomo', $data['autonomo'] ?? session()->get('autonomo'));
        session()->put('cliente', $data['cliente'] ?? session()->get('cliente'));
    }

    public static function routes()
    {
        return
            Route::controller(ProfileController::class)->group(function () {
                // ------------------- RUTAS REDIRECCIONES -------------------
                Route::get('/profile', 'index')->name('pagePerfil');

                // ------------------- RUTAS VISTAS -------------------
                Route::get('/get-dashboard-view', 'getDashboardView');
                Route::get('/get-history-payment-view', 'getHistoryPaymentView');
                Route::get('/get-my-favorites-view', 'getFavoritesView');
                Route::get('/get-my-promotions-view', 'getMyPromotionsView'); // Paquetes de promocion
                Route::post('/get-adv-packs-view', 'getAdvPacksView');

                // ------------------- RUTAS API -------------------
                Route::get('/get-dashboard', 'getDashboard'); // Devuelve los datos del usuario al entrar al panel de usuario
                Route::get('/general-data', 'generalData'); // Devuelve informacion adicional para el panel de usuario
                Route::post('/update-profile-data', 'storeProfileData'); // Envia los datos del formulario de perfil
                Route::post('/change-email', 'changeEmail'); // Cambia el email del usuario
                Route::post('/change-password', 'changePassword'); // Cambia la contraseña del usuario
                Route::post('/delete-account', 'deleteAccount'); // Elimina la cuenta del usuario
                Route::get('/get-payment-history', 'getPaymentHistory'); // Devuelve el historial de pagos del usuario
                Route::get('/get-my-promotions', 'getMyPromotions'); // Devuelve los paquetes de promocion del usuario
                Route::post('/change-data-visibility', 'changeDataVisibility'); // Cambia la visibilidad de los datos del usuario
                Route::post('/store-advertisement', 'storeAdvertisement'); // Crea o edita un anuncio
                Route::delete('/delete-advertisement/{id}', 'deleteAdvertisement'); // Elimina un anuncio
                Route::get('/get-advertisement/{id}', 'getAdvertisement'); // Devuelve un anuncio
                Route::post('/renewal-advertisement/{id}', 'renewalAvertisement'); // Renueva un anuncio
                Route::get('/get-favorites', 'getFavorites'); // Obtener los anuncios/autonomos favoritos del usuario
                Route::post('/become-autonomus', 'becomeAutonomus'); // Cambia el tipo de usuario a autonomo
                Route::post('/send-autonomus-data', 'sendAutonomusData'); // Envia los datos del formulario de autonomo
                Route::get('/get-rechazos-autonomus', 'getRechazosAutonomus'); // Devuelve los rechazos de autonomo
                Route::post('/get-adv-packs', 'getAdvPacks'); // Devuelve los paquetes de promocion activos segun el tipo seleccionado
                Route::get('/get-my-advertisements', 'gerMyAdvertisements'); // Devuelve los anuncios del usuario
                Route::post('/adquirir-promocion', 'adquirirPaquetePromocion'); // Permite adquirir un paquete de promocion
            });
    }
}
