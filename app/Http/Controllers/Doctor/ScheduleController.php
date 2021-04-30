<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\WorkDay;
use Carbon\Carbon;

class ScheduleController extends Controller
{
	private $days = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];
    public function edit(){

    	$workDays = WorkDay::where('user_id',auth()->user()->id)->get();
    	// la siguiente funcion me permite recibir arreglo y convertirlo a otro
        if(count($workDays) > 0){
    	   $workDays->map(function($workDay){
    		  $workDay->morning_start = (new Carbon($workDay->morning_start))->format('g:i A');
    		  $workDay->morning_end = (new Carbon($workDay->morning_end))->format('g:i A');
    		  $workDay->afternoon_start = (new Carbon($workDay->afternoon_start))->format('g:i A');
    		  $workDay->afternoon_end = (new Carbon($workDay->afternoon_end))->format('g:i A');
    		  return $workDay;
    	   });
        }else{
            $workDays = collect();
            for($i=0; $i<7; $i++)
                $workDays->push(new WorkDay());
        }
    	$days = $this->days;
    	return view('schedule',compact('workDays','days'));
    }

    public function store(Request $request){
    	//dd($request->all());
    	//die();
    	$active = $request->input('active') ?: []; // si no vienen elementos  asigna un array vacio
    	$morning_start = $request->input('morning_start');
    	$morning_end = $request->input('morning_end');
    	$afternoon_start = $request->input('afternoon_start');
    	$afternoon_end = $request->input('afternoon_end');

    	$errors = [];
    	for($i=0; $i<7; $i++){
    		if($morning_start[$i] > $morning_end[$i]){
    			$errors [] = "Las horas del turno de la mañana son incosistentes para el dia " . $this->days[$i] . " .";
    		}

    		if($afternoon_start[$i] > $afternoon_end[$i]){
    			$errors [] = "Las horas del turno de la tarde son incosistentes para el dia ". $this->days[$i]. " .";
    		}
    		WorkDay::updateOrCreate(
    			['day' => $i, // son elementos que hay que buscar para ver si ya estan
    			'user_id' => auth()->id()],
    			[
    				'active' => in_array($i, $active), // si esta el elemento retorna 1 y si no un cero
    				'morning_start' => $morning_start[$i],
    				'morning_end' => $morning_end[$i],
    				'afternoon_start' => $afternoon_start[$i],
    				'afternoon_end' => $afternoon_end[$i]

    			]
    		);
    	}

    	if(count($errors) > 0)
    		return back()->with(compact('errors'));

    	$notificacion = 'Los cambios se han guardado correctamente.';
    	return back()->with(compact('notificacion'));

    }
}
