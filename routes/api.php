<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffRegistration;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/try', [AuthController::class, 'test']);
    Route::post('/verify_staff/{staff_id}',[StaffRegistration::class, 'verify_staff']);
    Route::post('/register_staff',[StaffRegistration::class, 'register_staff']);
    Route::post('/login_staff', [StaffRegistration::class, 'login_staff']);
});

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::prefix('v1')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        /*Route::post('/vitals', [MainController::class, 'vitals']);
        Route::post('/diagnosis', [MainController::class, 'diagnosis']);
        Route::post('/symptoms', [MainController::class, 'symptoms']);
        Route::post('/lab_results', [MainController::class, 'lab_results']);
        Route::post('/lab_result_type', [MainController::class, 'lab_result_type']);
        Route::post('/update_vitals', [MainController::class, 'update_vitals']);*/
    });
});

Route::post('/vitals', [MainController::class, 'vitals']);
        Route::post('/diagnosis', [MainController::class, 'diagnosis']);
        Route::post('/symptoms', [MainController::class, 'symptoms']);
        Route::post('/lab_results', [MainController::class, 'lab_results']);
        Route::post('/lab_result_type', [MainController::class, 'lab_result_type']);
        Route::post('/update_vitals', [MainController::class, 'update_vitals']);
        Route::post('/search_vitals/{patient_id}', [MainController::class, 'search_vitals']);
        Route::post('/fetch_diagnosis/{patient_id}', [MainController::class, 'fetch_diagnosis']);
        Route::post('/fetch_prescription/{patient_id}', [MainController::class, 'fetch_prescription']);

Route::get('/test', function(){
    return "test";
});

