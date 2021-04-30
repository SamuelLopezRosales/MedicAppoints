<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    //specialties
    // $specialty->users()
    public function users()
    {
    	return $this->belongsToMany(User::class)->withTimestamps();
    }
}
