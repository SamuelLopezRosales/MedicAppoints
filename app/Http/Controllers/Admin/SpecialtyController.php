<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Specialty;
use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	private function performValidation(Request $request){
		//dd($resquest->all());
    	$rules = [
    		'name' => 'required|min:3'
    	];
    	$messages = [
    		'name.required' => 'Es necesario ingresar el nombre ',
    		'name.min' => 'Como minimo el nombre debe tener 3 caracteres'
    	];
    	$this->validate($request,$rules, $messages); // si hay un error lo retorna y bloquea el flujo
	}

    public function index(){
    	// obtener el listado de espacialidades
    	$specialties = Specialty::all();
    	return view('specialties.index',compact('specialties'));
    }

    public function create(){
    	return view('specialties.create');
    }

    public function store(Request $request){
    	//dd($resquest->all());
    	$this->performValidation($request);
    	 // si hay un error lo retorna y bloquea el flujo

    	$specialty = new Specialty();
    	$specialty->name = $request->input('name');
    	$specialty->description = $request->input('description');
    	$specialty->save();  // realiza un insert en la tabla specialties

    	$notificacion = 'La especialidad se ha registrado correctamente';
    	return redirect('/specialties')->with(compact('notificacion'));// la variable se va a crear como una variable de sesion
    }

    public function edit(Specialty $specialty){
    	return view('specialties.edit', compact('specialty'));
    }

     public function update(Request $request, Specialty $specialty){
    	//dd($resquest->all());
    	$this->performValidation($request);

    	$specialty->name = $request->input('name');
    	$specialty->description = $request->input('description');
    	$specialty->save();  // realiza un UPDATE en la tabla specialties
    	$notificacion = 'La especialidad se ha actualizado correctamente';
    	return redirect('/specialties')->with(compact('notificacion'));
    }

    public function destroy(Specialty $specialty){
    	$deleteName = $specialty->name;
    	$specialty->delete(); # eliminar una especialidad
    	$notificacion = 'La especialidad '.$deleteName.' se ha eliminado correctamente';
    	return redirect('/specialties')->with(compact('notificacion'));
    }
}
