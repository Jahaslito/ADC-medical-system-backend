<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffRegistration;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\LabRequestController;
use App\Http\Controllers\PatientVisitController;
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
    Route::get('/doctors', [StaffRegistration::class, 'show_all_doctors']);
    Route::get('/nurses', [StaffRegistration::class, 'show_all_nurses']);
    Route::get('/lab_technicians', [StaffRegistration::class, 'show_all_lab_technicians']);
    Route::get('/receptionists', [StaffRegistration::class, 'show_all_receptionists']);
    Route::get('/patients', [PatientController::class, 'index']);
    Route::post('/search_patient', [PatientController::class, 'show']);
    Route::post('/patient', [PatientController::class, 'search']);
    Route::post('/research_images', [DiseaseController::class, 'data_collection']);


});

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::prefix('v1')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/vitals', [MainController::class, 'vitals']);
        Route::post('/diagnosis', [MainController::class, 'diagnosis']);
        Route::post('/symptoms', [MainController::class, 'symptoms']);
        Route::post('/lab_results', [MainController::class, 'lab_results']);
        Route::post('/lab_result_type', [MainController::class, 'lab_result_type']);
        Route::post('/update_vitals', [MainController::class, 'update_vitals']);
        Route::post('/search_vitals/{patient_id}', [MainController::class, 'search_vitals']);
        Route::post('/fetch_diagnosis/{patient_id}', [MainController::class, 'fetch_diagnosis']);
        Route::post('/fetch_prescription/{patient_id}', [MainController::class, 'fetch_prescription']);
        Route::post('/insert_prescription', [MainController::class, 'insert_prescription']);
        Route::post('/appointment', [AppointmentController::class, 'appointment']);
        Route::post('/query_appointment/{start_date}/{end_date}', [AppointmentController::class, 'query_appointment']);
        Route::post('/request_lab', [LabRequestController::class, 'request_lab']);
        Route::post('/update_lab_request', [LabRequestController::class, 'update_lab_request']);
        Route::post('/insert_patient_visit', [PatientVisitController::class, 'insert_patient_visit']);
        Route::post('/update_patient_visit', [PatientVisitController::class, 'update_patient_visit']);
        Route::post('/fetch_presc_diag/{patient_id}', [MainController::class, 'fetch_presc_diag']);
        Route::post('/update_patient/{patient_id}', [PatientController::class, 'update_patient']);
        Route::get('/fetch_all_results/{patient_id}', [MainController::class, 'fetch_all_results']);
        Route::get('/fetch_lab_request/{status}', [LabRequestController::class, 'fetch_lab_request']);
        Route::get('/fetch_patient_with_status/{status}', [PatientVisitController::class, 'fetch_patient_with_status']);
        Route::get('/fetch_all_lab_results', [MainController::class, 'fetch_all_lab_results']);
        Route::get('/fetch_patient_lab_request/{patient_id}', [LabRequestController::class, 'fetch_patient_lab_request']);
        Route::get('/doctor_query_appointment/{start_date}/{end_date}', [AppointmentController::class, 'doctor_query_appointment']);
        Route::get('/patient_query_appointment', [AppointmentController::class, 'patient_query_appointment']);
    });
});

Route::get('/test', function(){
    return "test";
});

