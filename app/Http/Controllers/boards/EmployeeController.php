<?php

namespace App\Http\Controllers\boards;

use App\Helpers\Helpers;
use App\Http\Controllers\APICallsController;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class EmployeeController extends Controller
{

    public function __construct(Request $request)
    {
        $this->nameCrud = 'Employee';
    }
    public function index(Request $request){

        return view('content/boards/employees/board');
    }

    public function view(Request $request, $id = null){

        try{
            if(isset($id)){
                $employee = $this->getEmployee($request, $id);

                $method = 'view';
                $avatar = isset($employee['avatar']) ? (config('app.FILES_URL') . $employee['avatar']) : null;

                return view('content/boards/employees/form', [
                    'method' => $method,
                    'nameCrud' => $this->nameCrud,
                    'employee' => $employee,
                    'avatar' => $avatar,
                ]);
            }else{
                abort(404);
            }
        }catch (\Exception $exception){
            Helpers::newLog(__FUNCTION__, $request, $exception);
            abort(404);
        }
    }

    public function edit(Request $request, $id){

        try{
            if(isset($id)){
                $employee = $this->getEmployee($request, $id);
                $method = 'edit';

                $avatar = isset($employee['avatar']) ? (config('app.FILES_URL') . $employee['avatar']) : null;

                return view('content/boards/employees/form', [
                    'method' => $method,
                    'nameCrud' => $this->nameCrud,
                    'employee' => $employee,
                    'avatar' => $avatar,
                ]);
            }else{
                abort(404);
            }
        }catch (\Exception $exception){
            Helpers::newLog(__FUNCTION__, $request, $exception);
            abort(404);
        }
    }

    public function create(Request $request){

        $method = 'create';
        return view('content/boards/employees/form', [
            'method' => $method,
            'nameCrud' => $this->nameCrud,
        ]);
    }

    public function getDataJson(Request $request){
        $url = "/api/employees/getDataJson";
        $response = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request->all(), $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function delete(Request $request, $id){
        $url = "/api/employees/delete/$id";
        $response = APICallsController::callApi('delete', config('app.GATEWAY_URL') . $url, $request->all(), $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function store(Request $request, $id=null){
        $url = isset($id) ? "/api/employees/store/$id" : "/api/employees/store";
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request->all(), $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function suspend(Request $request, $id=null){
        $url = isset($id) ? "/api/employees/suspend/$id" : "/api/employees/suspend";
        $response = APICallsController::callApi('post', config('app.GATEWAY_URL') . $url, $request->all(), $request);
        return response()->json($response->getOriginalContent(), $response->status());
    }

    public function getEmployee($request, $id){
        $url = "/api/employees/getEmployee/$id";
        $employee = APICallsController::callApi('get', config('app.GATEWAY_URL') . $url, $request->all(), $request);

        if($employee->getStatusCode() != 200){
            abort(404);
        }

        return $employee->getOriginalContent();
    }

    public static function routes()
    {
        return
            Route::controller(EmployeeController::class)->prefix('employees')->as('employee.')->group(function(){
                Route::get('/board', 'index')->name('index');
                Route::get('/new', 'create')->name('new');
                Route::get('/view/{id?}', 'view')->name('view');
                Route::get('/edit/{id?}', 'edit')->name('edit');
                Route::get('/getDataJson', 'getDataJson');

                Route::post('/store/{id?}', 'store')->name('store');
                Route::post('/suspend/{id?}','suspend')->name('suspend');

                Route::delete('/delete/{id}', 'delete');
            });
    }

}
