@extends('layouts.panel')

@section('content')

       <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Mis Citas</h3>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <div class="card-body">
                @if(session('notificacion'))
              <div class="alert alert-success" role="alert">
                {{ session('notificacion') }}
              </div>
               @endif

               <!-- nav -->
               <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#confirmed-appointments" role="tab" aria-selected="true">Mis proximas citas</a>
                  </li>
                   <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pending-appointments" role="tab" aria-controls="pills-profile" aria-selected="false">Citas por confirmar</a>
                  </li>
                    <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#old-appointments" role="tab" aria-controls="pills-profile" aria-selected="false">Historial de citas atendidas</a>
                  </li>
               </ul>
              </div>

             <!-- table responsive -->
               <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="confirmed-appointments" role="tabpanel"
                  aria-labelledby="pills-home-tab">
                  @include('appointments.tables.comfirmed')
                </div>
                <div class="tab-pane fade " id="pending-appointments" role="tabpanel"
                  aria-labelledby="pills-profile-tab">
                  @include('appointments.tables.pending')
                </div>
                 <div class="tab-pane fade " id="old-appointments" role="tabpanel"
                  aria-labelledby="pills-profile-tab">
                  @include('appointments.tables.old')
                </div>
               </div>


          </div>
      </div>
@endsection
