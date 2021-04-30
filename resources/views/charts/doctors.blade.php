@extends('layouts.panel')

@section('content')
      <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Reporte: Médicos mas activos</h3>
                </div>

              </div>
            </div>

              <!-- Projects table -->
              <div class="card-body">
               <figure class="highcharts-figure">
                    <div id="container"></div>

                </figure>
              </div>


      </div>
@endsection

@section('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="{{ asset('js/charts/doctors.js') }}"></script>
@endsection
