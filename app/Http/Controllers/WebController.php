<?php

namespace App\Http\Controllers;

use App\Http\Controllers\APICallsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class WebController extends Controller
{

    // ------------------- FUNCIONES REDIRECCIONES -------------------

    public function PreRevolver()
    {
        return view('/pages/pre-revolver/index');
    }

    // Redireccion al HOME
    public function index()
    {
        return view('/pages/home/index');
    }

    // Redireccion al listado general
    public function search()
    {
        return view('/pages/search/index');
    }

    // Redireccion a autónomo detalle
    public function pageAutonomoDetalle($autonomoId)
    {
        return view('/pages/autonomo-detalle/index', compact('autonomoId'));
    }

    // Redireccion a anuncio detalle
    public function pageAnuncioDetalle($anuncioId)
    {
        return view('/pages/anuncio-detalle/index', compact('anuncioId'));
    }

    public function conditions(Request $request)
    {
        $pageConfigs = ['myLayout' => 'front'];
        return view('pages.home.conditions', ['pageConfigs' => $pageConfigs]);
    }


    // ------------------- FUNCIONES VISTAS -------------------

    // Funcion que devuelve la vista para el home con los autonomos destacados
    public function getAutonomosDestacadosView()
    {
        $autonomos = $this->getAutonomosDestacados();
        return view('/_partials/listado-autonomos-destacados', compact('autonomos'));
    }

    // Funcion que devuelve la vista para el home con los anuncios destacados
    public function getAnunciosDestacadosView()
    {
        $anuncios = $this->getAnunciosDestacados();
        return view('/_partials/listado-anuncios-destacados', compact('anuncios'));
    }

    // Funcion que devuelve las vistas para el home con los recursos necesarios como las profesiones
    public function getAllView()
    {
        $responseOriginal = $this->getAll();
        $profesiones = $responseOriginal["profesiones"];

        return response()->json([
            'profesiones' => view('_partials.listado-profesiones', compact('profesiones'))->render(),
        ]);
    }

    // Funcion que devuelve la vista de autónomos para la pagina de busqueda
    public function searchAutonomosView(Request $request)
    {
        $response = $this->searchAutonomos($request);
        return view('/_partials/listado-autonomos-search', compact('response'));
    }

    // Funcion que devuelve la vista de anuncios para la pagina de busqueda
    public function searchAnunciosView(Request $request)
    {
        $response = $this->searchAnuncios($request);
        return view('/_partials/listado-anuncios-search', compact('response'));
    }

    // Funcion que devuelve las vistas de autónomo concreto para la pagina de autonomo-detalle
    public function getAutonomoView($autonomoId)
    {
        $autonomo = $this->getAutonomo($autonomoId);
        $autonomos_destacados = $this->getAutonomosDestacados();
        $aside = view('pages.autonomo-detalle.autonomo-detalle-aside', compact('autonomo'))->render();
        $content = view('pages.autonomo-detalle.autonomo-detalle-content', compact('autonomo', 'autonomos_destacados'))->render();

        return response()->json([
            'aside' => $aside,
            'content' => $content,
        ]);
    }

    // Funcion que devuelve las vistas de anuncio concreto para la pagina de anuncio-detalle
    public function getAnuncioView($anuncioId)
    {
        $anuncio = $this->getAnuncio($anuncioId);
        $anuncios_destacados = $this->getAnunciosDestacados();
        $aside = view('pages.anuncio-detalle.anuncio-detalle-aside', compact('anuncio'))->render();
        $content = view('pages.anuncio-detalle.anuncio-detalle-content', compact('anuncio', 'anuncios_destacados'))->render();

        return response()->json([
            'aside' => $aside,
            'content' => $content,
        ]);
    }

    // ------------------- FUNCIONES API -------------------

    // Funcion que obtiene los autónomos destacados
    public function getAutonomosDestacados()
    {
        $url = "/api/web/autonomos/destacados";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url);
        $autonomos_destacados = $response->getOriginalContent()["autonomos_destacados"] ?? [];
        return $autonomos_destacados;
    }

    // Funcion que obtiene los anuncios destacados
    public function getAnunciosDestacados()
    {
        $url = "/api/web/anuncios/destacados";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url);
        $anuncios_destacados = $response->getOriginalContent()["anuncios_destacados"] ?? [];
        return $anuncios_destacados;
    }

    // Funcion que obtiene recursos necesarios como las profesiones
    public function getAll()
    {
        $url = "/api/web/getAll";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url);
        $responseOriginal = $response->getOriginalContent();
        return $responseOriginal;
    }

    // Funcion que obtiene un autónomo en concreto
    public function getAutonomo($autonomoId)
    {
        $url = "/api/web/autonomos/get/$autonomoId";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url);
        $autonomo = $response->getOriginalContent();
        return $autonomo;
    }

    // Funcion que obtiene un anuncio en concreto
    public function getAnuncio($anuncioId)
    {
        $url = "/api/web/anuncios/get/$anuncioId";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url);
        $anuncio = $response->getOriginalContent();
        return $anuncio;
    }

    // Funcion que devuelve los resultados de la busqueda de autónomos (con o sin filtros)
    public function searchAutonomos(Request $request)
    {
        $this->updateSessionFilters($request, 'autonomos');
        $url = "/api/web/autonomos";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request ,$request);
        $response = $response->getOriginalContent()["autonomos"];
        return $response;
    }

    // Funcion que devuelve los resultados de la busqueda de anuncios (con o sin filtros)
    public function searchAnuncios(Request $request)
    {
        $this->updateSessionFilters($request, 'anuncios');
        $url = "/api/web/anuncios";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request ,$request);
        $response = $response->getOriginalContent()["anuncios"];
        return $response;
    }

    // Funcion que pone o quita un like a un autónomo/anuncio
    public function setLike(Request $request)
    {
        if(!is_null(session()->get('cliente'))){ // Si hay un cliente logueado agregamos el ID del mismo en caso contrario, la peticion devolverá "Unauthorized"
            $request->request->add(['cliente_id' => session()->get('cliente')['_id']]);
        }
        $url = "/api/cliente/likes/set";
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request ,$request)->getOriginalContent();
        return $response;
    }

    // Funcion que devuelve las opciones de reporte
    public function getOpcionesReportes(Request $request)
    {
        $url = "/api/web/reportes/opciones";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request, $request);
        $opciones_reportes = $response->getOriginalContent();
        return $opciones_reportes;
    }

    public function sendReport(Request $request)
    {
        $url = "/api/web/reportes/add";
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request, $request)->getOriginalContent();
        return $response;
    }

    // ------------------- EXTRA -------------------

    private function updateSessionFilters($request, $search_mode = 'autonomos')
    {
        session()->put('filters', $request->all());
        session()->put('search_mode', $search_mode);
    }

    public static function routes()
    {
        return
            Route::controller(WebController::class)->group(function(){
                // ------------------- RUTAS REDIRECCIONES -------------------
                Route::get('/pre-revolver', 'PreRevolver');
                Route::get('/', 'index')->name('home');
                Route::get('/search', 'search')->name('search');
                Route::get('/autonomo/{id}', 'pageAutonomoDetalle')->name('pageAutonomoDetalle');
                Route::get('/anuncio/{id}', 'pageAnuncioDetalle')->name('pageAnuncioDetalle');
                Route::get('/conditions', 'conditions')->name('conditions');

                // ------------------- RUTAS VISTAS -------------------
                Route::get('/autonomos-destacados-view', 'getAutonomosDestacadosView');
                Route::get('/anuncios-destacados-view', 'getAnunciosDestacadosView');
                Route::get('/getAll-view', 'getAllView');
                Route::get('/search-autonomos-view', 'searchAutonomosView');
                Route::get('/search-anuncios-view', 'searchAnunciosView');
                Route::get('/get-autonomo-view/{id}', 'getAutonomoView');
                Route::get('/get-anuncio-view/{id}', 'getAnuncioView');

                // ------------------- RUTAS API -------------------
                Route::get('/getAll', 'getAll'); // Devuelve los recursos necesarios como las profesiones
                Route::get('/anuncios-destacados', 'getAnunciosDestacados'); // Devuelve los anuncios destacados
                Route::get('/autonomos-destacados', 'getAutonomosDestacados'); // Devuelve los autónomos destacados
                Route::get('/search-autonomos', 'searchAutonomos'); // Devuelve los resultados de la busqueda de autónomos
                Route::get('/search-anuncios', 'searchAnuncios'); // Devuelve los resultados de la busqueda de anuncios
                Route::get('/get-autonomo/{id}', 'getAutonomo'); // Devuelve un autónomo en concreto
                Route::get('/get-anuncio/{id}', 'getAnuncio'); // Devuelve un anuncio en concreto
                Route::post('set-like', 'setLike'); // pone o quita un like a un autónomo/anuncio
                Route::get('/get-opciones-reporte', 'getOpcionesReportes'); // Devuelve las opciones de reporte
                Route::post('/send-report', 'sendReport'); // Envía un reporte

            });
    }
}
