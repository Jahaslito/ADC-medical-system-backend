<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Appointment extends Model
{
    use HasFactory, hasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'patient_id',
        'date_of_app',
        'time_of_app',
        'doctor_id',
        'receptionist_id',

    ];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function doctor() {
    	return $this->hasOne(Doctor::class);
    }

    public function receptionist() {
    	return $this->hasOne(Receptionist::class);
    }
}
