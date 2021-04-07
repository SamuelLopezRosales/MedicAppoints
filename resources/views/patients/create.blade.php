@extends('layouts.panel')

@section('content')
      <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Nuevo Paciente</h3>
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
              <form action="{{ url('patients') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="name">Nombre del Paciente</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                  <label for="dni">Dni</label>
                  <input type="text" name="dni" class="form-control" value="{{ old('dni') }}">
                </div>
                  <div class="form-group">
                  <label for="address">Dirección</label>
                  <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                </div>

                  <div class="form-group">
                  <label for="phone">Teléfono</label>
                  <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="form-group">
                  <label for="password">Contraseña</label>
                  <input type="text" name="password" class="form-control" value="{{ $contra }}">
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
              </form>
            </div>
      </div>
@endsection
