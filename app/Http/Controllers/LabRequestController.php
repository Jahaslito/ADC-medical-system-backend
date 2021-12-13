<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Validator;
use App\Models\User;
use App\Models\Doctor;
use App\Models\LabRequest;

class LabRequestController extends Controller
{
	// This function is used by the doctor to request a lab sample for a patient.
 	public function request_lab(Request $request) {
 		$fields = $request->validate([
	 		'patient_id' => 'required',
	        'doctor_id' => 'required',
	        'description' => 'required',
	    ]);

	    $lab_request = LabRequest::create([
	    	'patient_id' => $fields['patient_id'],
	    	'doctor_id' => $fields['doctor_id'],
	    	'description' => $fields['description']
	    ]);

	    if ($lab_request) {
	    	$pat_name = User::where('id', $fields['patient_id'])->get();
	    	$doct_name = Doctor::where('id', $fields['doctor_id'])->get();
	    	$pat_name = json_decode($pat_name);
	    	$doct_name = json_decode($doct_name);

	    	$response = [
	    		'patient_name' => $pat_name[0]->first_name. ' '. $pat_name[0]->last_name,
	    		'doctor_name' => $doct_name[0]->doctor_first_name. ' '. $doct_name[0]->doctor_last_name,
	    		'data' => $lab_request,
	    		'message' => 'Lab Sample requested successfully'
	    	];

	    	return response($response);

        } else {
            return responder()->error(404, "There was an error requesting the lab sample!!!Please try again")->respond(404);
        }
 	}   

 	// This function tracks the status of a requested lab sample.
 	public function update_lab_request(Request $request) {
 		$field = $request->validate([
 			'patient_id' => 'required'
 		]);

 		$update = LabRequest::where('patient_id', $field['patient_id'])->update(array('status' => '1'));

 		if ($update) {            
            return response([
                "message" => "Requested Lab Sample updated successfully"
            ], 200);

        } else {
            return responder()->error(404, "There was an error updating the requested lab sample!!!Please confirm the patient id and try again")->respond(404);
        }
 	}

 	// This function fetches all lab requests given the status
 	public function fetch_lab_request($status) {
 		$results = DB::table('lab_requests')
 					->join('users', 'lab_requests.patient_id', '=', 'users.id')
 					->join('doctors', 'lab_requests.doctor_id', '=', 'doctors.id')
 					->select('lab_requests.lab_request_id', 'lab_requests.patient_id', 'users.first_name', 'users.last_name', 'lab_requests.description', 'lab_requests.doctor_id', 'doctors.doctor_first_name', 'doctors.doctor_last_name', 'lab_requests.status', 'lab_requests.created_at')
 					->where('lab_requests.status', $status)
 					->get();

 		if ($results) {
 			$response = [
 				'data' => $results,
 				'message' => 'Lab Requests fetched successfully'
 			];

            return response($response);

        } else {
            return responder()->error(404, "There was an error fetching the requested lab samples!!!Please confirm status and try again")->respond(404);
        }
 	}
}
