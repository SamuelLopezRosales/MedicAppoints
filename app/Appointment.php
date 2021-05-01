<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Specialty;
use App\User;
use Carbon\Carbon;

class Appointment extends Model
{
    protected $fillable = [
    	'description',
    	'specialty_id',
    	'doctor_id',
    	'patient_id',
    	'scheduled_date',
    	'type'
    ];

    protected $hidden = [
        'specialty_id',
        'doctor_id',
        'scheduled_time'
    ];

    protected $appends = [
        'scheduled_time_12'
    ];

    public function specialty(){
    	return $this->belongsTo(Specialty::class);
    }

    public function doctor(){ // como la funcion es doctor laravel busca automaticamente una columna doctor_id
    	return $this->belongsTo(User::class);
    }

    public function patient(){ // como la funcion es doctor laravel busca automaticamente una columna doctor_id
    	return $this->belongsTo(User::class);
    }

    public function getScheduledTime12Attribute(){
    	return (new Carbon($this->scheduled_time))->format('g:i A');
    }

    // relacio 1 a 1 una cita solo tendra un detalle de cancelacion
    // cuando es una relacion 1 a 1 de un lado es hasOne y del otro belongsTo
    public function cancellation(){
        return $this->hasOne(CancelledAppointment::class);
    }

}
