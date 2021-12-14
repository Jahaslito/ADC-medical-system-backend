<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Video;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Validator;

class VideoController extends Controller
{
    public function insert_link(Request $request) {
    	$fields = $request->validate([
            'patient_id' => 'required',
	        'doctor_id' => 'required',
	        'date_of_meet' => 'required',
	        'time_of_meet' => 'required',
	        'video_link' => 'required',
	        'status' => 'required'
        ]);

        $video = Video::create([
        	'patient_id' => $fields['patient_id'],
	        'doctor_id' => $fields['doctor_id'],
	        'date_of_meet' => $fields['date_of_meet'],
	        'time_of_meet' => $fields['time_of_meet'],
	        'video_link' => $fields['video_link'],
	        'status' => $fields['status']
        ]);

        if ($video) {            
            return response([
                "message" => "Video link successfully inserted"
            ], 200);

        } else {
            return responder()->error(404, "There was an error inserting the video link!!!Please try again")->respond(404);
        }
    }

    // Updating the video link
    public function update_link($video_id, Request $request) {
    	$fields = $request->validate([
            'patient_id' => 'required',
	        'doctor_id' => 'required',
	        'date_of_meet' => 'required',
	        'time_of_meet' => 'required',
	        'video_link' => 'required',
	        'status' => 'required'
        ]);

    	$update_link = DB::table('videos')
    						->where('video_id', $video_id)
    						->update([
    							'patient_id' => $fields['patient_id'],
						        'doctor_id' => $fields['doctor_id'],
						        'date_of_meet' => $fields['date_of_meet'],
						        'time_of_meet' => $fields['time_of_meet'],
						        'video_link' => $fields['video_link'],
						        'status' => $fields['status']
    						]);

    	if ($update_link) {
            return response([
                "message" => "Video link successfully updated"
            ], 200);
        } else {
            return responder()->error(404, "There was an error updating the video link. Please confirm the video ID and try again!")->respond(404);  
        }
    }

    // Fetching by patient_id
    public function query_by_patient($patient_id) {
    	$get_link = DB::table('videos')
    					->join('users', 'videos.patient_id', '=', 'users.id')
    					->join('doctors', 'videos.doctor_id', '=', 'doctors.id')
    					->select('videos.video_id', 'videos.patient_id', 'users.first_name', 'users.last_name', 'doctors.doctor_first_name', 'doctors.doctor_last_name', 'videos.date_of_meet', 'videos.time_of_meet', 'videos.created_at', 'videos.updated_at')
    					->where('videos.patient_id', $patient_id)
    					->get();


    	if ($get_link) {
    		$response = [
				'data' => $get_link,
				'message' => "Video link fetched successfully"
			];

    		return response($response);

        } else {
            return responder()->error(404, "There was an error fetching the video link!!!Please try again")->respond(404);
        }
    }

    // Fetching by doctor_id
    public function query_by_doctor($doctor_id) {
    	$get_link = DB::table('videos')
    					->join('users', 'videos.patient_id', '=', 'users.id')
    					->join('doctors', 'videos.doctor_id', '=', 'doctors.id')
    					->select('videos.video_id', 'videos.patient_id', 'users.first_name', 'users.last_name', 'doctors.doctor_first_name', 'doctors.doctor_last_name', 'videos.date_of_meet', 'videos.time_of_meet', 'videos.created_at', 'videos.updated_at')
    					->where('videos.doctor_id', $doctor_id)
    					->get();


    	if ($get_link) {
    		$response = [
				'data' => $get_link,
				'message' => "Video link fetched successfully"
			];

    		return response($response);

        } else {
            return responder()->error(404, "There was an error fetching the video link!!!Please try again")->respond(404);
        }
    }

    // Fetching all video links
    public function query_all_links() {
    	$get_link = DB::table('videos')
    					->join('users', 'videos.patient_id', '=', 'users.id')
    					->join('doctors', 'videos.doctor_id', '=', 'doctors.id')
    					->select('videos.video_id', 'videos.patient_id', 'users.first_name', 'users.last_name', 'doctors.doctor_first_name', 'doctors.doctor_last_name', 'videos.date_of_meet', 'videos.time_of_meet', 'videos.created_at', 'videos.updated_at')
    					->get();


    	if ($get_link) {
    		$response = [
				'data' => $get_link,
				'message' => "Video links fetched successfully"
			];

    		return response($response);

        } else {
            return responder()->error(404, "There was an error fetching the video links!!!Please try again")->respond(404);
        }
    }
}
