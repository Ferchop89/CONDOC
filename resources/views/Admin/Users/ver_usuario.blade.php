@extends('layouts.app')
@section('title',"Usuario {$user->id}")
@section('content')
<div class="container">
    {{-- <div class="card"> --}}
    <h1 class="pb-1">Perfil del usuario "{{ $user->username }}"</h1>
    <div class="card-body">
        <div class="form-group">
            <label for="name">Nombre del Usuario</label>
            <div class="form-control">{{ $user->name }}</div>
        </div>
        <div class="form-group">
            <label for="username">Alias</label>
            <div class="form-control">{{ $user->username }}</div>
        </div>
        <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <div class="form-control">{{ $user->email }}</div>
        </div>

        <div class="form-group">
            <label for="is_active">Usuario Activo</label>
            <input type="checkbox" {{ $user->is_active ? 'checked' : ''   }} name="is_active" OnClick="return false;" >
        </div>

        <div>
            <label>Roles en el Sistema</label>
        </div>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    {{-- {{$roles=[]}} --}}
                    @foreach ($roles as $role)
                        <th scope="col">{{ $role->descripcion}}</th>
                    @endforeach
                    {{-- {{dd($role->descripcion)}} --}}
                </tr>
            </thead>
            <td>

                <div class="form-check form-check-inline">
                    <input type="checkbox" {{ $user->roles()->where('nombre','Admin')->count()>0 ? 'Checked' : '' }} class="form-check-input" name="Admin" id="Admin" value="1" OnClick="return false;">
                    <label class="form-check-label" for="Admin">Admin</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    <input type="checkbox" {{ $user->roles()->where('nombre','FacEsc')->count()>0 ? 'Checked' : '' }} class="filled-in form-check-input" name="FacEsc" id="FacEsc" value="2" OnClick="return false;">
                    <label class="form-check-label" for="FacEsc">FacEsc</label>
                </div>
                <div class="procedencia">
                    @if($user->procedencia_id != null)
                        <p>{{ App\Models\Procedencia::where('id',$user->procedencia_id)->pluck('procedencia')[0] }}</p>
                    @else
                        <p>Sin procedencia</p>
                    @endif
                </div>
            </td>

            <td>
                <div class="form-check form-check-inline">
                    <input type="checkbox" {{ $user->roles()->where('nombre','AgUnam')->count()>0 ? 'Checked' : '' }} class="form-check-input" name="AgUnam" id="AgUnam" value="3" OnClick="return false;">
                    <label class="form-check-label" for="AgUnam">AgUnam</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    <input type="checkbox" {{ $user->roles()->where('nombre','Jud')->count()>0 ? 'Checked' : '' }} class="form-check-input" name="Jud" id="Jud" value="4" OnClick="return false;" OnClick="return false;">
                    <label class="form-check-label" for="Jud">Jud</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    <input type="checkbox" {{ $user->roles()->where('nombre','Sria')->count()>0 ? 'Checked' : '' }} class="filled-in form-check-input" name="Sria" id="Sria" value="5" OnClick="return false;">
                    <label class="form-check-label" for="Sria">Sria</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    <input type="checkbox" {{ $user->roles()->where('nombre','JSecc')->count()>0 ? 'Checked' : '' }} class="form-check-input" name="JSecc" id="JSecc" value="6" OnClick="return false;">
                    <label class="form-check-label" for="JSecc">JSecc</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    <input type="checkbox" {{ $user->roles()->where('nombre','JArea')->count()>0 ? 'Checked' : '' }} class="form-check-input" name="JArea" id="JArea" value="7" OnClick="return false;">
                    <label class="form-check-label" for="JArea">JArea</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    <input type="checkbox" {{ $user->roles()->where('nombre','Ofisi')->count()>0 ? 'Checked' : '' }} class="filled-in form-check-input" name="Ofisi" id="Ofisi" value="8" OnClick="return false;">
                    <label class="form-check-label" for="Ofisi">Ofisi</label>
                </div>
            </td>
            <td>
                <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input" name="Invit" id="Invit" value="9" checked="checked"  OnClick="return false;">
                    <label class="form-check-label" for="Invit">Invit</label>
                </div>
            </td>
        </table>
        <p class="button">
            <a href="{{ route('admin/usuarios') }}" class="btn btn-primary waves-effect waves-light">Regresar a la lista de usuarios</a>
        </p>

    </div>
    {{-- </div> --}}
</div>
@endsection