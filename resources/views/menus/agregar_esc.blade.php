@extends('layouts.app')
@section('title', 'CONDOC | Agregar Escuela Procedencia')

@section('location')
<div style="padding-top: 1%">
	<p id="navegacion">
		<a href="{{ url('/home') }}"><span class="glyphicon glyphicon-home"></span>
		<span> </span> Licenciatura </a> >> 
		<a href="{{ url('/datos_personales') }}"> Revisión de Estudios </a> >>
		<a href="{{ url('/agregar_esc/'.$num_cta) }}"> Agregar escuela de procedencia </a></p>
</div>
@endsection

@section('content')
<div id="pocos">

	<form class="form-group" method="POST" action="{{ url('/agregar_esc/'.$num_cta) }}">
		{!! csrf_field() !!}

		<h3 id="titulo1">Agregar escuela de procedencia</h3>
		<div id="instrucciones1">Ingresa los datos que se solicitan.</div>

		<div class="row">
			<div class="col-sm-6" id="texto1">
				Número de cuenta:
			</div>
			<div class="col-sm-6" id="campo1">
				<input id="num_cta" type="text" class="form-control" name="num_cta" value="{{$num_cta}}" maxlength="9">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6" id="texto1">
				Nivel escuela:
			</div>
			<div class="col-sm-6" id="campo1">
				<select>
					<option value="fem" selected>Femenino</option>
				    <option value="mas">Masculino</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6" id="texto1">
				Plan carrera
			</div>
			<div class="col-sm-6" id="campo1">
				<select>
					<option value="fem" selected>Femenino</option>
				    <option value="mas">Masculino</option>
				</select>
			</div>
		</div>

		<div class="botones">
			<button type="submit" class="btn btn-primary waves-effect waves-light">
			  	Agregar
			</button>
			<a class="btn btn-danger" href="{{ url('/rev_est/'.$num_cta) }}" role="button">Volver</a>
		</div>
	</form>
</div>
@endsection

@section('animaciones')

@endsection