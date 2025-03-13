<?php

namespace App\Http\Controllers\boards;

use App\Http\Controllers\APICallsController;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class ProfessionController extends Controller {
    public string $nameCrud = "";
    public string $crudRouteName = "professions";

    public function __construct(Request $request) {
        $this->nameCrud = "Profession";
    }

    public function index(Request $request) {

        return view("content/boards/{$this->crudRouteName}/board");
    }

    public function view(Request $request, $id = null) {

        if (isset($id)) {
            $url = "/api/{$this->crudRouteName}/getProfession/$id";
            $profession = APICallsController::callApi("get", config("app.GATEWAY_URL") . $url, $request->all(), $request)->getOriginalContent();
            $method = "view";

            return view("content/boards/{$this->crudRouteName}/form", [
                "method" => $method,
                "nameCrud" => $this->nameCrud,
                "profession" => $profession,
            ]);
        }
    }

    public function create(Request $request) {

        $method = "create";
        return view("content/boards/{$this->crudRouteName}/form", [
            "method" => $method,
            "nameCrud" => $this->nameCrud,
        ]);
    }

    public function edit(Request $request, $id) {
        if (isset($id)) {
            $url = "/api/{$this->crudRouteName}/getProfesion/$id";
            $profession = APICallsController::callApi("get", config("app.GATEWAY_URL") . $url, $request->all(), $request)->getOriginalContent();
            $method = "edit";

            $image = isset($profession["image"]) ? (config("app.FILES_URL") . $profession["image"]) : null;


            return view("content/boards/{$this->crudRouteName}/form", [
                "method" => $method,
                "nameCrud" => $this->nameCrud,
                "profession" => $profession,
            ]);
        }
    }

    public function getDataJson(Request $request) {
        $url = "/api/{$this->crudRouteName}/getDataJson";
        //dd(config("app.GATEWAY_URL") . $url);
        $response = APICallsController::callApi("post", config("app.GATEWAY_URL") . $url, $request->all(), $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function store(Request $request, $id = null) {
        $url = isset($id) ? "/api/{$this->crudRouteName}/store/$id" : "/api/{$this->crudRouteName}/store";
        $response = APICallsController::callApi("post", config("app.GATEWAY_URL") . $url, $request->all(), $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function suspend(Request $request, $id = null) {
        $url = "/api/{$this->crudRouteName}/suspend/$id";
        $response = APICallsController::callApi("post", config("app.GATEWAY_URL") . $url, $request->all(), $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function delete(Request $request, $id) {
        $url = "/api/{$this->crudRouteName}/delete/$id";
        $response = APICallsController::callApi("post", config("app.GATEWAY_URL") . $url, $request->all(), $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public static function routes() {
        return
            Route::group(["prefix" => "professions", "as" => "profession."], function () {
                Route::get("/board", [ProfessionController::class, "index"])->name("index");
                Route::get("/new", [ProfessionController::class, "create"])->name("new");
                Route::get("/view/{id?}", [ProfessionController::class, "view"])->name("view");
                Route::get("/edit/{id?}", [ProfessionController::class, "edit"])->name("edit");
                Route::get("/getDataJson", [ProfessionController::class, "getDataJson"]);

                Route::post("/store/{id?}", [ProfessionController::class, "store"])->name("store");
                Route::post("/suspend/{id?}", [ProfessionController::class, "suspend"])->name("suspend");

                Route::delete("/delete/{id}", [ProfessionController::class, "delete"]);
            });
    }
}
