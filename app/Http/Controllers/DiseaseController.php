<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    public function data_collection(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'image' => 'required'
        ]);
        if(!$request->hasFile('image')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('image');
        if(!$file->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $path = public_path() . '/uploads/images/store/';
        $file->move($path, $file->getClientOriginalName());
        $disease = Disease::create([
            'disease_name' => $data['name'],
            'disease_image' => $data['image']
        ]);


        return responder()->success($disease);
    }
}
