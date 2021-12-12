<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Validator;
use App\Models\User;
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
            return response([
                "message" => "Lab Sample requested successfully"
            ], 200);

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
}
