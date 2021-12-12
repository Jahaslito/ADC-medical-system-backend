<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Validator;
use App\Models\User;
use App\Models\PatientVisit;

class PatientVisitController extends Controller
{
	// This function inserts the patients to the patients visit table
	public function insert_patient_visit(Request $request) {
		$field = $request->validate([
    		'patient_id' => 'required'
    	]);
    	
    	$insert_visit = PatientVisit::create([
    		'patient_id' => $field['patient_id']
    	]);	

    	if ($insert_visit) {            
            return response([
                "message" => "Patient Visit record inserted successfully"
            ], 200);

        } else {
            return responder()->error(404, "There was an error inserting the patient visit record!!!Please try again")->respond(404);
        }
	}

	// This function updates the status of the patient visit by adding 1 to the status every time the api is called
    public function update_patient_visit(Request $request) {
    	$field = $request->validate([
    		'patient_id' => 'required'
    	]);

    	$status = PatientVisit::where('patient_id', $field['patient_id'])->value('status');

    	$update_status = PatientVisit::where('patient_id', $field['patient_id'])->update(array('status' => $status+1));

    	if ($update_status) {            
            return response([
                "message" => "Patient Visit record updated successfully"
            ], 200);

        } else {
            return responder()->error(404, "There was an error updating the patient visit record!!!Please try again")->respond(404);
        }
    } 

    // This function fetches the patients with a particular given status
    public function fetch_patient_with_status($status) {
    	$results = DB::table('patient_visits')
                    ->join('users', 'patient_visits.patient_id', '=', 'users.id')
                    ->where('patient_visits.status', $status)
                    ->orderBy('patient_visits.updated_at', 'desc')
                    ->get();

        $response = [
        	'data' => $results,
        	'message' => 'Patients successfully fetched'
        ];

    	if ($response) {
 			return response($response);
        } else {
            return responder()->error(404, "There was an error retrieving the requested patients' status!!!Please confirm the patient id and try again")->respond(404);
        }
    }
}
