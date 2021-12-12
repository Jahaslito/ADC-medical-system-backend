<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class LabRequest extends Model
{
    use HasFactory, hasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'description',
        'status'
    ];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function doctor() {
    	return $this->belongsTo(Doctor::class);
    }
}
