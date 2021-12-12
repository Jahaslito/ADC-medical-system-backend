<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Doctor extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number'
    ];

    public function appointment() {
    	return $this->hasMany(Appointment::class);
    }

    public function labrequest() {
    	return $this->hasMany(LabRequest::class);
    }
}
