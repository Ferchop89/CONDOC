@extends('layouts.app')
@section('title','CONDOC | '.$title)
@section('location')
    <div>
    	<p id="navegacion">
            <a href="{{ route('home') }}"><i class="fa fa-home" style="font-size:28px"></i></a>
    		<span> >> </span>
    		<a> Licenciatura </a>
            <span> >> </span>
    		<a href="#"> {{$title}} </a> </p>
    </div>
@endsection
@section('content')
<div class="capsule no-agunam">
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h2 id="titulo">{{$title}}</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <h5>Por favor inserta un número de cuenta válido</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li> {{ $error}}  </li>
                    @endforeach
                </ul>
            </div>
        @endif

      <form id="corte" action="{{ route('alta_noagunam') }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('put')}}
        <input type="text" name="cuenta" id="cuenta" placeholder="No. de Cuenta" value="{{ old('cuenta') }}"/>
        <p class="button">
            <button type="submit" class="btn btn-primary text-yellow">Nuevo Expediente</i></button>
        </p>
      </form>

    </div>
    @if($expedientes->isNotEmpty())
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">cuenta</th>
                <th scope="col">Nombre</th>
                <th scope="col">procedencia</th>
                <th scope="col">Corte</th>
                <th scope="col">Listado</th>
                {{-- <th scope="col">Encontrado</th> --}}
                <th scope="col">Operación</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{dd($expedientes)}} --}}
            @foreach($expedientes as $key => $expediente)
                <tr>
                    <th scope="row">{{ $key+1}}</th>
                    <td>{{ $expediente->cuenta }}</td>
                    <td>{{ $expediente->nombre }}</td>
                    <td>{{ $expediente->procedencia }}</td>
                    <td>{{ $expediente->listado_corte }}</td>
                    <td>{{ $expediente->listado_id }}</td>
                    {{-- <td><input type="checkbox" {{ $expediente->encontrado ? 'checked' : ''   }} name="activo" OnClick="return false;" ></td> --}}
                    <td>
                        <form action="{{ route('eliminar_noagunam',[ $expediente->id ]) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE')}}
                            {{-- <a href="{{ route('ver_usuario',[ 2014 ]) }}"><i class="fa fa-eye" style="font-size:34px;color:#c5911f"></i></a> --}}
                            <a href="{{ route('ver_noagunam',['expediente' => $expediente->id ]) }}"><i class="fa fa-eye" style="font-size:34px;color:#c5911f"></i></a>
                            <a href="{{ route('editar_noagunam',[ $expediente->id ]) }}"><i class="fa fa-edit" style="font-size:34px;color:#c5911f"></i></a>
                            <button type="submit"><i class="fa fa-trash" style="font-size:34px;color:#c5911f"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    @else
        <p>
            No hay expedientes.
        </p>
    @endif
</div>
{{-- <div class="paginador">
    {{ $expedientes->links()}}
</div> --}}
@endsection

{{-- // barra lateral --}}
{{-- @section('barralateral')
  <h2>Barra lateral personalizada</h2>
  @parent
@endsection --}}
