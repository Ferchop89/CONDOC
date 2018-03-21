@extends('layout')

@section('title',"Usuario {$user->id}")

@section('content')

<div class="card">
  <h4 class="card-header">Mostrado los detalles del usuario #{{ $user->id }}</h4>
  <div class="card-body">
    <div class="form-group">
      <label for="name">Nombre del Usuario</label>
      <div class="form-control">{{ $user->name }}</div>
    </div>
    <div class="form-group">
      <label for="correo">Correo Electrónico</label>
      <div class="form-control">{{ $user->email }}</div>
    </div>
    <div class="form-group">
      <label for="login">Login</label>
      <div class="form-control">{{ $user->login }}</div>
    </div>

    <div>
      <label>Roles en el Sistema</label>
    </div>

    <div class="form-check form-check-inline">
        <input type="checkbox" {{ $user->roles()->where('nombre','Admin')->count()>0 ? 'Checked' : '' }} class="form-check-input" name="Admin" id="Admin" value="1">
        <label class="form-check-label" for="Admin">Admin</label>
    </div>

    <div class="form-check form-check-inline">
        <input type="checkbox" {{ $user->roles()->where('nombre','FacEsc')->count()>0 ? 'Checked' : '' }} class="filled-in form-check-input" name="FacEsc" id="FacEsc" value="2">
        <label class="form-check-label" for="FacEsc">FacEsc</label>
    </div>

    <div class="form-check form-check-inline">
        <input type="checkbox" {{ $user->roles()->where('nombre','AgUnam')->count()>0 ? 'Checked' : '' }} class="form-check-input" name="AgUnam" id="AgUnam" value="3">
        <label class="form-check-label" for="AgUnam">AgUnam</label>
    </div>

    <div class="form-check form-check-inline">
        <input type="checkbox" {{ $user->roles()->where('nombre','Jud')->count()>0 ? 'Checked' : '' }} class="form-check-input" name="Jud" id="Jud" value="4">
        <label class="form-check-label" for="Jud">Jud</label>
    </div>

    <div class="form-check form-check-inline">
        <input type="checkbox" {{ $user->roles()->where('nombre','Sria')->count()>0 ? 'Checked' : '' }} class="filled-in form-check-input" name="Sria" id="Sria" value="5">
        <label class="form-check-label" for="Sria">Sria</label>
    </div>

    <div class="form-check form-check-inline">
        <input type="checkbox" {{ $user->roles()->where('nombre','JSecc')->count()>0 ? 'Checked' : '' }} class="form-check-input" name="JSecc" id="JSecc" value="6">
        <label class="form-check-label" for="JSecc">JSecc</label>
    </div>

    <div class="form-check form-check-inline">
        <input type="checkbox" {{ $user->roles()->where('nombre','JArea')->count()>0 ? 'Checked' : '' }} class="form-check-input" name="JArea" id="JArea" value="7">
        <label class="form-check-label" for="JArea">JArea</label>
    </div>

    <div class="form-check form-check-inline">
        <input type="checkbox" {{ $user->roles()->where('nombre','Ofisi')->count()>0 ? 'Checked' : '' }} class="filled-in form-check-input" name="Ofisi" id="Ofisi" value="8">
        <label class="form-check-label" for="Ofisi">Ofisi</label>
    </div>

    <div class="form-check form-check-inline">
        <input type="checkbox" class="form-check-input" name="Invit" id="Invit" value="9" checked="checked" disabled>
        <label class="form-check-label" for="Invit">Invit</label>
    </div>

    <br><br>

    <a href="{{ route('users') }}" class="btn btn-link">Regresar a la lista de usuarios</a>
  </div>
</div>

@endsection
