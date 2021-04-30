<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class CancelledAppointment extends Model
{
    public function cancelled_by(){
    	return $this->belongsTo(User::class);
    }
}
