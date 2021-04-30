 <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Descripción</th>
                    <th scope="col">Especialidad</th>
                      @if($role == 'patient')
                    <th scope="col">Médico</th>
                    @elseif($role == 'doctor')
                    <th scope="col">Paciente</th>
                    @endif
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($pendingAppointments as $appointment)
                  <tr>
                    <th scope="row">
                      {{ $appointment->description }}
                    </th>
                    <td>
                     {{ $appointment->specialty->name }}
                    </td>
                        @if($role == 'patient')
                    <td>
                     {{ $appointment->doctor->name }}
                    </td>
                    @elseif($role == 'doctor')
                    <td>
                     {{ $appointment->patient->name }}
                    </td>
                    @endif
                    <td>
                     {{ $appointment->scheduled_date }}
                    </td>
                    <td>
                     {{ $appointment->scheduled_time_12 }}
                    </td>
                    <td>
                     {{ $appointment->type }}
                    </td>
                    <td>
                     {{ $appointment->status }}
                    </td>
                    <td>
                       @if($role == 'admin')
                      <a class="btn btn-sm btn-primary" title="Ver cita"
                      href="{{ url('/appointments/'.$appointment->id) }}">
                      Ver
                    </a>
                    @endif

                      @if($role == 'doctor' || $role == 'admin')
                      <form action="{{ url('/appointments/'.$appointment->id.'/confirm') }}" method="POST"
                        class="d-inline-block">
                      @csrf

                        <button type="submit" class="btn btn-sm btn-success" title="Confirmar cita"
                        data-toggle="tooltip">
                          <i class="ni ni-check-bold"></i>
                        </button>
                      </form>
                      <!--<a href="{{ url('appointments/'.$appointment->id.'/cancel') }}" class="btn btn-sm btn-danger">
                         <i class="ni ni-fat-delete"></i>
                      </a>-->
                      @endif

                      <!-- si es paciente cambia el estado sin guardar detalle -->
                      <form action="{{ url('appointments/'.$appointment->id.'/cancel') }}" method="POST"
                        class="d-inline-block">
                      @csrf

                        <button type="submit" class="btn btn-sm btn-danger" title="Cancelar cita"
                        data-toggle="tooltip">
                          <i class="ni ni-fat-delete"></i>
                        </button>
                      </form>



                      <!-- boton cancealr -->

                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

     <div class="card-body">
            {{ $pendingAppointments->links() }}
          </div>