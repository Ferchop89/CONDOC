@extends('layouts.app')
@section('title', 'CONDOC | Solicitud de RE por Alumno')
@section('location')
    >> {{$num_cta}}
@endsection
@section('content')
    <div id="is">
        {{-- {{dd($trayectoria[1])}} --}}
        <div class="contenido">
            <div class="info-personal">
                <img src="images/sin_imagen.png" alt="">
                <div class="info">
                    <div class="fila">
                        <label for="">Nº de Cuenta: </label>{{$num_cta}}
                        <label for="">Nombre:</label>
                    </div>
                    <div class="fila">
                        <label for="">Nº de Plantel: </label>{{$trayectoria[1]->plantel_clave}}
                        <label for="">Nombre del Plantel: </label>{{$trayectoria[1]->plantel_nombre}}
                    </div>
                    <div class="fila">
                        <label for="">Plan de Estudios: </label>
                    </div>
                </div>
            </div>
            {{$trayectoria[1]->nivel}}
        </div>
    </div>
@endsection
