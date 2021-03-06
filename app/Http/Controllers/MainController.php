<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Validator;
use App\Models\User;
use App\Models\VitalSigns;
use App\Models\Diagnosis;
use App\Models\Symptoms;
use App\Models\LabResult;
use App\Models\LabResultType;
use App\Models\Prescription;

class MainController extends Controller
{
    // Vital Signs
    public function vitals(Request $request) {
        $fields = $request->validate([
            'patient_id' => 'required',
            'weight' => 'required',
            'temperature' => 'required',
            'blood_pressure' => 'required',
            'height' => 'required',
            'pulse_rate' => 'required',

            'lab_test_id' => 'required',
            'staff_id' => 'required'
        ]);

        $weight = $fields['weight'];
        $height = $fields['height'];

        $BMI = $weight / ($height*$height);

        $vitalsign = VitalSigns::create([
            'patient_id' => $fields['patient_id'],
            'weight' => $fields['weight'],
            'temperature' => $fields['temperature'],
            'blood_pressure' => $fields['blood_pressure'],
            'height' => $fields['height'],
            'pulse_rate' => $fields['pulse_rate'],
            'BMI' => $BMI,
            'lab_test_id' => $fields['lab_test_id'],
            'staff_id' => $fields['staff_id']
        ]);

        if ($vitalsign) {
            return responder()->success($vitalsign)->meta(["message" => "Patient's vitals have been successfully inserted"]);
            
            return response([
                "message" => "PatientController records have been successfully inserted"
            ], 200);

        } else {
            return responder()->error(404, "There was an error inserting the patient's vitals!!!Please try again")->respond(404);
        }
    }

    // Update Vital Signs
    public function update_vitals(Request $request) {
        $fields = $request->validate([
            'patient_id' => 'required',
            'weight' => 'required',
            'blood_pressure' => 'required',
            'temperature' => 'required',
            'height' => 'required',
            'pulse_rate' => 'required',
            'lab_test_id' => 'required',
            'staff_id' => 'required'
        ]);
        
        $weight = $fields['weight'];
        $height = $fields['height'];

        $BMI = $weight / ($height*$height);

        $updated_vitals = DB::table('vital_signs')
                                ->where('patient_id', $fields['patient_id'])
                                ->update([
                                    'weight' => $fields['weight'],
                                    'blood_pressure' => $fields['blood_pressure'],
                                    'temperature' => $fields['temperature'],
                                    'height' => $fields['height'],
                                    'BMI' => $BMI,
                                    'pulse_rate' => $fields['pulse_rate'],
                                    'lab_test_id' => $fields['lab_test_id'],
                                ]);

        if ($updated_vitals) {
            return response([
                "message" => "Patient's vitals have been successfully updated"
            ], 200);
        } else {
            return responder()->error(404, "There was an error updating the patient's vitals. Please confirm the patient ID and try again!")->respond(404);  
        }
    }

    // Searching vitals for a particular patient
    public function search_vitals($patient_id) {
        $vital_signs = VitalSigns::where('patient_id', $patient_id)->orderBy('created_at', 'desc')->get();

        if (count($vital_signs)) {
            return responder()->success($vital_signs->toArray())->meta(["message" => "Patient's vitals fetched successfully"]);
        } else {
            return responder()->error(404, 'Patient ID id not found!')->respond(404);
        }
    }

    // Fetching patient diagnosis
    public function fetch_diagnosis($patient_id) {
        $patient_diagnosis = Diagnosis::where('patient_id', $patient_id)->orderBy('created_at', 'desc')->get();

        if (count($patient_diagnosis)) {
            return responder()->success($patient_diagnosis->toArray())->meta(["message" => "Patient's diagnoses fetched successfully"]);
        } else {
            return responder()->error(404, 'Patient ID id not found!')->respond(404);
        }
    }

    // This function inserts patient prescriptions
    public function insert_prescription(Request $request) {
        $fields = $request->validate([
            'name' => 'required',
            'quantity' => 'required',
            'diagnosis_id' => 'required',
            'dosage' => 'required'
        ]); 

        $prescription = Prescription::create([
            'name' => $fields['name'],
            'quantity' => $fields['quantity'],
            'diagnosis_id' => $fields['diagnosis_id'],
            'dosage' => $fields['dosage']
        ]); 

        if ($prescription) {
            return response([
                "message" => "Patient Prescription inserted successfully"
            ], 200);
        } else {
            return responder()->error(404, "There was an error inserting the patient prescriptions!!!Please try again")->respond(404);  
        }
    }

    // This function fetches the prescription of a patient
    public function fetch_prescription($patient_id) {
        $pid = DB::table('diagnoses')
                    ->select('prescription_id')
                    ->where('patient_id', $patient_id)
                    ->orderBy('created_at', 'desc')
                    ->value('prescription_id');

        $prescription = Prescription::where('prescription_id', $pid)->get();

        if ($prescription) {
            return responder()->success($prescription)->meta(["message" => "Prescription fetched successfully"]);
        } else {
            return response([
                "message" => "There was an error fetching the prescription!!Please confirm the patient ID and try again"
            ], 404);
        }
    }

    // Inputting diagnosis
    public function diagnosis(Request $request) {
        $fields = $request->validate([
            'staff_id' =>'required',
            'patient_id' => 'required',
            'diagnosis' => 'required',
        ]);

        $diagnoses = Diagnosis::create([
            'staff_id' => $fields['staff_id'],
            'patient_id' => $fields['patient_id'],
            'diagnosis' => $fields['diagnosis'],
        ]);

        if ($diagnoses) {
            $data = Diagnosis::where('patient_id', $fields['patient_id'])->orderBy('updated_at', 'desc')->first();

            if ($data) {
                return responder()->success($data)->meta(["message" => "Diagnosis records have been successfully inserted"]);
            } else {
                return responder()->error(404, "There was an error inserting the diagnosis records!!!Please try again")->respond(404);
            }

            
        } else {
            return responder()->error(404, "There was an error inserting the diagnosis records!!!Please try again")->respond(404);  
        }

    }

    // Inputting symptoms
    public function symptoms(Request $request) {
        $fields = $request->validate([
            'patient_id' => 'required',
            'description' => 'required'
        ]);

        $symptom = Symptoms::create([
            'patient_id' => $fields['patient_id'],
            'description' => $fields['description']
        ]);

        if ($symptom) {
            return responder()->success($symptom)->meta(["message" => "Patient's Symptoms have been successfully inserted"]);
        } else {
            return responder()->error(404, "There was an error inserting the patient symptoms!!!Please try again")->respond(404);
        }
    }

    // Inputting the lab result type
    public function lab_result_type(Request $request) {
        $fields = $request->validate([
            'lab_result_name' => 'required',
            'patient_id' =>'required',
            'unit' => 'required'
        ]);

        $result_type = LabResultType::create([
            'patient_id' => $fields['patient_id'],
            'lab_result_name' => $fields['lab_result_name'],
            'unit' => $fields['unit']
        ]);

        if ($result_type) {
            return responder()->success($result_type)->meta(["message" => "Result Type records have been successfully inserted"]);
        } else {
            return responder()->error(404, "There was an error inserting the Result Type records!!!Please try again")->respond(404);  
        }
    }

    // Inputting the lab result
    public function lab_results(Request $request) {
        $fields = $request->validate([
            'patient_id' => 'required',
            'test_type' => 'required',
            'lab_result_id' => 'required'
        ]);

        $lab_result = LabResult::create([
            'patient_id' => $fields['patient_id'],
            'test_type' => $fields['test_type'],
            'lab_result_id' => $fields['lab_result_id']
        ]);

        if ($lab_result) {
            return responder()->success($lab_result)->meta(["message" => "Lab records have been successfully inserted"]);
        } else {
            return responder()->error(404, "There was an error inserting the lab records!!!Please try again")->respond(404);  
        }
    }

    // This function fetches the prescription and diagnosis for a patient
    public function fetch_presc_diag($patient_id) {
        $results = DB::table('prescriptions')
                    ->join('diagnoses', 'prescriptions.diagnosis_id', '=', 'diagnoses.diagnosis_id')
                    ->where('diagnoses.patient_id', $patient_id)
                    ->orderBy('prescriptions.created_at', 'DESC')
                    ->get();

        $response = [
            'data' => $results,
            'message' => "Patient Diagnosis and Prescription fetched successfully"
        ];

        if ($results) {
            return response($response);
        } else {
            return responder()->error(404, "There was an error fetching the patient diagnosis and prescription records!!!Please try again")->respond(404);  
        }
    }

    // This function fetches all available lab results
    public function fetch_all_lab_results() {
        $results = DB::table('lab_results')
                    ->join('lab_result_types', 'lab_results.lab_result_id', '=', 'lab_result_types.lab_result_id')
                    ->join('users', 'lab_results.patient_id', '=', 'users.id')
                    ->select('lab_results.lab_test_id', 'lab_results.patient_id', 'users.first_name', 'users.last_name', 'lab_results.test_type', 'lab_result_types.lab_result_id', 'lab_results.created_at', 'lab_results.updated_at', 'lab_result_types.lab_result_name', 'lab_result_types.unit')
                    ->orderBy('lab_result_types.updated_at', 'DESC')
                    ->get();

        return $results;
    }

    // This function is to fetch lab results with their respective lab result types
    public function fetch_all_results($patient_id) {
        $results = DB::table('lab_results')
                    ->join('lab_result_types', 'lab_results.lab_result_id', '=', 'lab_result_types.lab_result_id')
                    ->join('users', 'lab_results.patient_id', '=', 'users.id')
                    ->select('lab_results.lab_test_id', 'lab_results.patient_id', 'users.first_name', 'users.last_name', 'lab_results.test_type', 'lab_result_types.lab_result_id', 'lab_results.created_at', 'lab_results.updated_at', 'lab_result_types.lab_result_name', 'lab_result_types.unit')
                    ->where('lab_results.patient_id', $patient_id)
                    ->orderBy('lab_result_types.updated_at', 'DESC')
                    ->get();

        $response = [
            'data' => $results,
            'message' => "Patient Lab Results fetched successfully"
        ];

        if ($results) {
            return response($response);
        } else {
            return responder()->error(404, "There was an error fetching the patient lab results records!!!Please try again")->respond(404);  
        }
    }
}
