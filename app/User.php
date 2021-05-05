<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','dni','address','phone','role'
    ];


    public static $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ];

    public static function createPatient(array $data){
        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'patient'
        ]);
    }

    protected $hidden = [
        'password', 'remember_token','pivot',
        'email_verified_at','created_at','updated_at'
    ];

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class)->withTimestamps();
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopePatients($query){
        return $query->where('role','patient');
    }

     public function scopeDoctors($query){
        return $query->where('role','doctor');
    }

    // $user->asPatientAppointments  ->requestedAppointments
    // $user->asDoctorAppointments -> attendedAppointments
    public function asDoctorAppoitnments()
    {
        return $this->hasMany(Appointment::class,'doctor_id');
    }

    public function asPatientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function attendedAppointments()
    {
        return $this->asDoctorAppoitnments()->where('status','Atendida');
    }

     public function cancelledAppointments()
    {
        return $this->asDoctorAppoitnments()->where('status','Cancelada');
    }


}
