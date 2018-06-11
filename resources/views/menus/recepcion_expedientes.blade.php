@extends('layouts.app')
@section('title', 'CONDOC | Recepción de Expedientes')
@section('estilos')
    {{-- <link href="{{ asset('css/recepcion.css') }}" rel="stylesheet"> --}}
@section('content')
    <div id="is" class="container recepcion-expedientes">
        <div class="encabezado">
                <h1>Recepción de Expedientes</h1> <span>{{date("d/m/y")}}</span>
        </div>
        {{-- <div class="form-group{{ $errors->has('fecha_nac') ? ' has-error' : '' }}">
              <label for="fecha_nac" class="col-md-4">Fecha de Nacimiento:<p class="obligatorio">*</p></label></label>
              <input type="date" name="fecha_nac" id="fecha_nac" class="form-control" value="{{ old('fecha_nac', $alumno->datos_personales_alumnos->fecha_nac->format('Y-m-d')) }}" autocomplete="off" @if ($errors->has('fecha_nac')) autofocus @endif>
              @if ($errors->has('fecha_nac'))
                <span class="help-block">
                  <strong>{{ $errors->first('fecha_nac') }}</strong>
                </span>
              @endif
        </div> --}}

        <div class="datos">

            <form action="{{ route("postRecepcion") }}" method="POST">
                {{-- {{ method_field('PUT')}} --}}
                {{ csrf_field() }}
                <div class="form-datos">
                    <div class="dato-in form-group{{ $errors->has('num_cta') ? ' has-error' : '' }}">
                        <label for="num_cta">Número de Cuenta</label>
                        <input type="text" name="num_cta" value="" maxlength="9">
                        @if ($errors->has('num_cta'))
                        <span class="help-block">
                          <strong>{{ $errors->first('num_cta') }}</strong>
                        </span>
                        @endif
                        <input type="submit" name="" value="Buscar">
                    </div>
                    {{var_dump($arreglo)}}
                </div>
            </form>
        </div>
        {{-- {{dd(isset($identidad))}}
        @if(isset($identidad))
            {{dd($identidad)}}
        @else
            {{-- {{dd($identidad)}} --}}
            {{-- {{"entre"}} --}}
        {{-- @endif --}}
    </div>

@endsection
{{-- @extends('layouts.app')
@section('title', 'CONDOC | Solicitud de RE por Alumno')
@section('content')
<div id="is" class="container">
            <div class="panel panel-default">
                <div class="panel-heading">Recepción de Expedientes por Alumno </div>
                <div class="panel-body">

                	<form class="form-group solicitud" method="POST" action="{{ route('Recepcion.PostExpedientes') }}">
                		{!! csrf_field() !!}

                        <label for="num_cuenta"> N° de cuenta: </label>
                    	<input id="num_cuenta" type="text" name="num_cuenta" value="" maxlength="9" />
                        @if ($errors->any())
                    	    <div id="error" class="alert alert-danger">
                    	        <ul>
                    	            @foreach ($errors->all() as $error)
                    	                <li>{{ $error }}</li>
                    	            @endforeach
                    	        </ul>
                    	    </div>
                    	@endif
                        <div class="btn-derecha">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                               	Consultar
                           	</button>
                        </div>

    				</form>
                </div>
			</div>
            @if(isset($nombre))
                <div class="info-alumno">
                    <div class="control">
                        <div class="panel-control">

                        </div>
                        <div class="fila">
                            <div class="dato num_cta">
                                <span>No. Cuenta: <p>30501661 - 4</p></span>
                            </div>
                            <div class="dato expediente">
                                <span>Expediente SI: <p>000000000</p></span>
                            </div>
                            <div class="dato tramite">
                                <span>Tipo Tramite: <p>DESCENTRALIZACIÓN</p></span>
                            </div>
                        </div>
                        <div class="fila">
                            <div class="dato nombre">
                                <span>Nombre: <p>CABALLERO*SORIA*GUADALUPE</p></span>
                            </div>
                        </div>
                        <div class="fila">
                            <div class="dato carrera">
                                <span>Carrera: <p>31207 MEDICO CIRUJANO (MODULAR)</p></span>
                            </div>
                        </div>
                        <div class="fila">
                            <div class="dato titulo">
                                <span>Título a obtener: <p> MÉDICA CIRUJANA</p></span>
                            </div>
                        </div>
                        <div class="fila">
                            <div class="dato nivel">
                                <span>NIVEL: <p>Licenciatura</p></span>
                            </div>
                            <div class="dato fecha_nac">
                                <span>Fec. Nac. <p>27/12/1993</p></span>
                            </div>
                            <div class="dato tipo">
                                <span>Tipo: <p></p></span>
                            </div>
                        </div>
                    </div>
                    <div class="recibido">
                        <div class="fila">
                            <span>Exp Ncta:</span>
                        </div>
                        <div class="fila">

                        </div>
                        <div class="fila">

                        </div>
                        <div class="fila">

                        </div>
                    </div>
                </div>
            @endif
</div>
@endsection --}}
