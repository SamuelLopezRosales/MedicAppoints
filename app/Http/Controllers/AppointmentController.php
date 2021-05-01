<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\Specialty;
use App\CancelledAppointment;
use Carbon\Carbon;
use App\Interfaces\ScheduleServiceInterface;
use Validator;
use App\Http\Requests\StoreAppointment;


class AppointmentController extends Controller
{
    public function index(){
        // hay que preguntar
        // paciente -> solo las que le corresponde
        // medico -> solo las que le corresponde
        // administrador todas
        // s everan 2 listas una de reservadas y otras de confirmadas
        $role = auth()->user()->role;
        if($role == 'admin'){
            // si es administrador seran todas las citas
             $pendingAppointments = Appointment::where('status','Reservada')
            ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
            ->paginate(10);
            $oldAppointments = Appointment::whereIn('status',['Atendida', 'Cancelada'])
            ->paginate(10);
        }elseif($role == 'doctor'){
            // si es doctor traera las que esten asociadas es dicho doctro
             $pendingAppointments = Appointment::where('status','Reservada')
            ->where('doctor_id', auth()->id())
            ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
            ->where('doctor_id', auth()->id())
            ->paginate(10);
            $oldAppointments = Appointment::whereIn('status',['Atendida', 'Cancelada'])
            ->where('doctor_id', auth()->id())
            ->paginate(10);

        }elseif($role === 'patient'){
            // traera las que estan asociadas a dicho paciente
             $pendingAppointments = Appointment::where('status','Reservada')
            ->where('patient_id', auth()->id())
            ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
            ->where('patient_id', auth()->id())
            ->paginate(10);
            $oldAppointments = Appointment::whereIn('status',['Atendida', 'Cancelada'])
            ->where('patient_id', auth()->id())
            ->paginate(10);
        }

        $appointments = Appointment::paginate(10);
        return view('appointments.index',compact('pendingAppointments', 'confirmedAppointments','oldAppointments', 'role'));
    }

    public function show(Appointment $appointment){
        $role = auth()->user()->role;
        return view('appointments.show',compact('appointment','role'));
    }

    public function create(ScheduleServiceInterface $scheduleService){
    	$specialties = Specialty::all();

        $specialtyId = old('specialty_id');
        if($specialtyId){
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
        }else{
            $doctors = collect();
        }

        $date = old('scheduled_date');
        $doctorId = old('doctor_id');
        if($date && $doctorId){
            $intervals = $scheduleService->getAvailableIntervals($date, $doctorId);
        }else{
            $intervals = null;
        }
        return view('appointments.create', compact('specialties', 'doctors', 'intervals'));
    }

    public function store(StoreAppointment $request, ScheduleServiceInterface $scheduleService){
        /*$validator->after(function ($validator) use ($request, $scheduleService) {
            $date = $request->input('scheduled_date');
            $doctorId = $request->input('doctor_id');
            $schedule_time = $request->input('scheduled_time');


            if(!$date || !$doctorId || !$schedule_time){
                return;
            }

            $start = new Carbon($schedule_time);

            // vamos a verificar si la hora seleccionada esta disponible
            if(!$scheduleService->isAvailableInterval($date, $doctorId, $start)){
                $validator->errors()
                        ->add('available_time', 'La hora seleccionada ya se encuentra reservada por otro paciente.');
            }

        });*/
    	$created = Appointment::createForPatient($request, auth()->id());

        if($created)
    	   $notificacion = "La cita se ha registrado correctamente.";
        else
            $notificacion = "Ocurrio un error al registrar la cíta médica";

    	return back()->with(compact('notificacion'));
    }


    public function postCancel(Appointment $appointment, Request $request){ // cuando lo casteamos laravel nos va dar un objeto
         if($request->has('justification')){
            $cancellation = new CancelledAppointment();
            $cancellation->justification = $request->input('justification');
            $cancellation->cancelled_by = auth()->id();
            //$appointment->justification = $request->input('justification');
            $appointment->cancellation()->save($cancellation);
        }

        $appointment->status = 'Cancelada';
        $appointment->save(); // updated

        $notification = "La cita se ha cancelado correctamente.";
        return redirect('/appointments')->with(compact('notification'));
    }

    public function showCancelForm(Appointment $appointment){
         if($appointment->status == 'Confirmada'){
            $role = auth()->user()->role;
        return view('appointments.cancel', compact('appointment','role'));
        }
        return redirect('/appointments');
    }

     public function postConfirm(Appointment $appointment){
        $appointment->status = 'Confirmada';
        $appointment->save(); // update

        $notification = 'La cita se ha confirmado correctamente';
        return redirect('appointments')->with(compact('notification'));
    }
}
