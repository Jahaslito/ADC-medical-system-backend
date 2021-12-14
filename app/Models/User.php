<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'date_of_birth',
        'address',
        'town',
        'gender'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function vitalsigns() {
        return $this->hasOne(VitalSigns::class);
    }

    public function symptoms() {
        return $this->hasMany(Symptoms::class);
    }

    public function labresult() {
        return $this->hasMany(LabResult::class);
    }

    public function diagnosis() {
        return $this->hasMany(Diagnosis::class);
    }

    public function appointment() {
        return $this->hasMany(Appointment::class);
    }

    public function patientVisit() {
        return $this->hasMany(PatientVisit::class);
    }

    public function labrequest() {
        return $this->hasMany(LabRequest::class);
    }

     public function video() {
        return $this->hasMany(Video::class);
    }
}
