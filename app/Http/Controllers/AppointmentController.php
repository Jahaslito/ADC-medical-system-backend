<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Validator;
use App\Models\User;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function appointment(Request $request) {
    	$fields = $request->validate([
            'patient_id' => 'required',
	        'date_of_app' => 'required|date',
	        'time_of_app' => 'required',
	        'doctor_id' => 'required',
	        'receptionist_id' => 'required',
        ]);

        $appt = Appointment::create([
        	'patient_id' => $fields['patient_id'],
	        'date_of_app' => $fields['date_of_app'],
	        'time_of_app' => $fields['time_of_app'],
	        'doctor_id' => $fields['doctor_id'],
	        'receptionist_id' => $fields['receptionist_id'],
        ]);

        if ($appt) {            
            return response([
                "message" => "PatientController records have been successfully inserted"
            ], 200);

        } else {
            return responder()->error(404, "There was an error making the appointment!!!Please try again")->respond(404);
        }
    }

    public function query_appointment($start_date, $end_date) {
    	$get_appointments = Appointment::whereBetween('date_of_app', [$start_date, $end_date])->get();

    	if ($get_appointments) {
            return responder()->success($get_appointments)->meta(["message" => "Appointments fetched successfully"]);
            
        } else {
            return responder()->error(404, "There was an error making the appointment!!!Please try again")->respond(404);
        }
    }
}
