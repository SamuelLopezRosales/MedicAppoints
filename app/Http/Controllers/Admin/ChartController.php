<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Appointment;
use DB;

class ChartController extends Controller
{
    public function appointments(){

    		$monthlyCounts = Appointment::select(
    			DB::raw('MONTH(created_at) as month'),
    			DB::raw('COUNT(1) as count')
    		)->groupBy('month')->get()->toArray();
    	// solamente tendremos el mes
    	// hacer una array que contenga 12 valores ceros
    		$counts = array_fill(0, 12, 0); // pocision empezar numer y el valor
    		foreach ($monthlyCounts as $monthlyCount){
    			$index = $monthlyCount['month']-1;
    			$counts[$index] = $monthlyCount['count'];
    		}

    		return view('charts.appointments',compact('counts'));

    }

    public function doctors(){
    	return view('charts.doctors');
    }
}
