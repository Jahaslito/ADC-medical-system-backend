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
	// This function creates an appointment for a patient
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

    // This function queries appointments between two dates
    public function query_appointment($start_date, $end_date) {
    	$get_appointments = DB::table('appointments')
			    				->join('users', 'appointments.patient_id', '=', 'users.id')
			    				->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
			    				->select('appointments.patient_id', 'users.first_name', 'users.last_name', 'appointments.date_of_app', 'appointments.time_of_app', 'appointments.doctor_id', 'doctors.doctor_first_name', 'doctors.doctor_last_name', 'appointments.created_at')
			    				->whereBetween('date_of_app', array($start_date, $end_date))
			    				->get();

    	if ($get_appointments) {
    		$response = [
				'data' => $get_appointments,
				'message' => "Appointments fetched successfully"
			];

    		return response($response);

        } else {
            return responder()->error(404, "There was an error making the appointment!!!Please try again")->respond(404);
        }
    }

    // This function queries the appointments a doctor has within certain dates
    public function doctor_query_appointment($start_date, $end_date, Request $request) {
    	$fields = $request->validate([
            'id' => 'required'
        ]);

        $get_appointments = DB::table('appointments')
			    				->join('users', 'appointments.patient_id', '=', 'users.id')
			    				->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
			    				->select('appointments.patient_id', 'users.first_name', 'users.last_name', 'appointments.date_of_app', 'appointments.time_of_app', 'appointments.doctor_id',  'doctors.doctor_first_name', 'doctors.doctor_last_name', 'appointments.created_at')
			    				->where('appointments.doctor_id', $fields['id'])
			    				->whereBetween('date_of_app', array($start_date, $end_date))
			    				->get();

    	if ($get_appointments) {
    		$response = [
				'data' => $get_appointments,
				'message' => "Appointments fetched successfully"
			];

    		return response($response);

        } else {
            return responder()->error(404, "There was an error making the appointment!!!Please try again")->respond(404);
        }
    }

    // This function queries appointments for the patient
    public function patient_query_appointment(Request $request) {
    	$fields = $request->validate([
            'patient_id' => 'required'
        ]);

        $get_appointments = DB::table('appointments')
			    				->join('users', 'appointments.patient_id', '=', 'users.id')
			    				->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
			    				->select('appointments.patient_id', 'users.first_name', 'users.last_name', 'appointments.date_of_app', 'appointments.time_of_app', 'appointments.doctor_id',  'doctors.doctor_first_name', 'doctors.doctor_last_name', 'appointments.created_at')
			    				->where('appointments.patient_id', $fields['patient_id'])
			    				->get();

    	if ($get_appointments) {
    		$response = [
				'data' => $get_appointments,
				'message' => "Appointments fetched successfully"
			];

    		return response($response);

        } else {
            return responder()->error(404, "There was an error making the appointment!!!Please try again")->respond(404);
        }
    }
}
