<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Video extends Model
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
        'date_of_meet',
        'time_of_meet',
        'video_link',
        'status'

    ];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function doctor() {
    	return $this->hasMany(Doctor::class);
    }

    public function receptionist() {
    	return $this->hasOne(Receptionist::class);
    }
}
