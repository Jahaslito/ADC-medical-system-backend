<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffRegistration;
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
    Route::get('/verify_staff/{staff_id}',[StaffRegistration::class, 'verify_staff']);
    Route::post('/register_staff',[StaffRegistration::class, 'register_staff']);
    Route::post('/login_staff', [StaffRegistration::class, 'login_staff']);
});

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::prefix('v1')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

    });
});

Route::get('/test', function(){
    return "test";
});

