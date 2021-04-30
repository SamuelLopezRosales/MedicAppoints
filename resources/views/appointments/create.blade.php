@extends('layouts.panel')

@section('content')
      <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Nueva cíta</h3>
                </div>
                <div class="col text-right">
                  <a href="{{ url('patients') }}" class="btn btn-sm btn-default">Volver</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                  <ul>
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                  </ul>
                </div>
              @endif


                @if (session('notificacion'))
                  <div class="alert alert-success" role="alert">
                    {{ session('notificacion') }}
                </div>
                 @endif
              <form action="{{ url('appointments') }}" method="POST">
                @csrf
                 <div class="form-group">
                  <label for="description">Descripción</label>
                  <input type="text" name="description" value="{{ old('description') }}" id="description" class="form-control"
                  placeholder="Describe brevemente la consulta" required>
                </div>

                <!----->
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="name">Especialidad</label>
                    <select name="specialty_id" id="specialty" class="form-control" required>
                      <option value="">Seleccione especialidad</option>
                      @foreach($specialties as $key => $specialty)
                        <option value="{{ $specialty->id }}" @if(old('specialty_id')== $specialty->id)
                  selected @endif>{{ $specialty->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="email">Medico</label>
                  <select name="doctor_id" id="doctor" class="form-control" required>
                    @foreach($doctors as $doctor)
                  <option value="{{ $doctor->id }}" @if(old('doctor_id')== $doctor->id)
                  selected @endif>{{ $doctor->name }}</option>
                  @endforeach
                  </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="dni">Fecha</label>
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input type="text" name="scheduled_date" id="date" class="form-control datepicker" value="{{ date('Y-m-d') }}" placeholder="selecciona la fecha" data-date-format="yyyy-mm-dd" data-date-start-date="{{ date('Y-m-d') }}" data-date-end-date="+30d" required value="{{old( 'scheduled_date' ,date('Y-m-d')) }}">
                  </div>
                </div>

                  <div class="form-group">
                <label for="address">Hora de atención</label>
                <div id="hours">
                  @if($intervals)
                   @foreach($intervals['morning'] as $key => $interval)
                      <div class="custom-control custom-radio mb-3">
                        <input type="radio" id="intervalMorning{{ $key }}" name="scheduled_time" class="custom-control-input" value="{{ $interval['start'] }}" required>
                        <label class="custom-control-label" for="intervalMorning{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                        </div>
                   @endforeach
                  @foreach($intervals['afternoon'] as $key => $interval)
                        <div class="custom-control custom-radio mb-3">
                        <input type="radio" id="intervalAfternoon{{ $key }}" name="scheduled_time" class="custom-control-input" value="{{ $interval['start'] }}" required>
                        <label class="custom-control-label" for="intervalAfternoon{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                        </div>
                   @endforeach
                  <div class="alert alert-info" role="alert">
                    Seleccione un médico y una fecha, para ver sus horas disponibles
                  </div>
                  @endif
                </div>

              </div>


                  <div class="form-group">
                <label for="phone">Tipo de consulta</label>
                <!-- 1 er input -->
                  <div class="custom-control custom-radio">
                    <input type="radio" id="type1" name="type" class="custom-control-input"
                    @if(old('type', 'Consulta') == 'Consulta') checked @endif value="Consulta">
                    <label class="custom-control-label" for="type1">Consulta</label>
                  </div>
                  <!-- 2 do input -->
                  <div class="custom-control custom-radio">
                    <input type="radio" id="type2" name="type" class="custom-control-input"
                    @if(old('type', 'Examen') == 'Examen') checked @endif value="Examen">
                    <label class="custom-control-label" for="type2">Examen</label>
                  </div>

                  <!-- tercer input -->
                  <div class="custom-control custom-radio">
                    <input type="radio" id="type3" name="type" class="custom-control-input"
                    @if(old('type', 'Operacion') == 'Operacion') checked @endif value="Operacion">
                    <label class="custom-control-label" for="type3">Operación</label>
                  </div>

              </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
              </form>
            </div>
      </div>
@endsection

@section('scripts')
<script src="{{ asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/js/appointments/create.js') }}"></script>
@endsection
