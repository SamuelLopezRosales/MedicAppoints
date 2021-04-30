<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Specialty;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = User::doctors()->get();
        return view('doctors.index',compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contra = Str::random(6);
        $specialties = Specialty::all();
        return view('doctors.create',compact('contra','specialties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'dni' => 'nullable|digits:8',
            'address' => 'nullable|min:5',
            'phone' => 'nullable|min:6'
        ];
        $this->validate($request,$rules);

        $user = User::create(
            $request->only('name','email','dni','address','phone')
            + [
                'role' => 'doctor',
                'password' => bcrypt($request->input('password'))
            ]
        );
        // asignar especialidades al medico
        $user->specialties()->attach($request->input('specialties')); // va a recibir el arreglo de las especilaidadex

        $notificacion = 'El Médico se ha registrado correctamnete.';
        return redirect('/doctors')->with(compact('notificacion'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor = User::doctors()->findOrFail($id);
        $specialties = Specialty::all();
        $specialty_ids = $doctor->specialties()->pluck('specialties.id');
        return view('doctors.edit',compact('doctor','specialties','specialty_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'dni' => 'nullable|digits:8',
            'address' => 'nullable|min:5',
            'phone' => 'nullable|min:6'
        ];
        $this->validate($request,$rules);

        $user = User::doctors()->findOrFail($id); // busco el objeto
        $data = $request->only('name','email','dni','address','phone');
        $password = $request->input('password');
        if($password)
            $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();

        $user->specialties()->sync($request->input('specialties'));

        $notificacion = 'El Médico se ha actualizado correctamnete.';
        return redirect('/doctors')->with(compact('notificacion'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $doctor)
    {
        $doctorName = $doctor->name;
        $doctor->delete();

        $notificacion = 'El médico '.$doctorName.' se ha eliminado correctamente.';
        return redirect('/doctors')->with(compact('notificacion'));
    }
}
