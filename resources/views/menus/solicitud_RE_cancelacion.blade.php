@extends('layouts.app')
@section('title', 'CONDOC | '.$title)
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
    <h2 id="titulo">{{$title}}</h2>
    @include('errors/flash-message')
    <div class="capsule solicitud_re">
        <div class="contenido">
            <div class="info">
                <div class="info-personal">
                    <img src="{{ asset('images/sin_imagen.png') }}" alt="">
                    <div class="info-personal-header">
                        <div class="fila">
                            <label for="">Nombre: </label>{{}}
                        </div>
                        <div class="fila">
                            <label for="">Nº de Cuenta: </label>{{}}
                        </div>
                        <div class="fila">
                            <label for="">CURP: </label>@if($identidad->curp) {{}} @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="fila">
                <form class="" action="index.html" method="post">
                    <button type="button" value="Regresar" class="btn btn-primary waves-effect waves-light" onclick="history.back(-1)" />
                        {{"Volver"}}
                    </button>
                </form>

            </div>
        </div>
        {{-- @endif --}}
    </div>
@endsection
