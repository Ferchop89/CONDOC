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

<div id="firmar" class="col-sm-6">
	<div>
		<label>Firma: </label>
		<input type="text" name="firma" id="firma" class="form-control" name="firma" value="">
	</div>
	<div class="botones">
		<button type="submit" class="btn btn-default">
		   	Guardar
		</button>
		<a class="btn btn-primary" href="{{ url('/home') }}" role="">Firmar</a>
		<a class="btn btn-danger" href="{{ url('/home') }}" role="">Salir</a>
	</div>
</div>

<div class="personal">
	<div class="row">
		<p><b>Info. personal: </b></p>
		<div id="texto" class="col-sm-6">
			CURP:
		</div>
		<div id="campo" class="col-sm-6">
			<input id="curp" type="text" class="form-control" name="curp" value="{{$identidad->curp}}" maxlength="18">
		</div>
	</div>
	<div class="row">
		<div id="texto" class="col-sm-6">
			Sexo:
		</div>
		<div id="campo" class="col-sm-6">
			@if($identidad->sexo == "FEMENINO")
				<select>
					<option value="fem" selected>Femenino</option>
				    <option value="mas">Masculino</option>
				</select>
			@else
				<select>
					<option value="mas" selected>Masculino</option>
				    <option value="fem">Femenino</option>
				</select>
			@endif
		</div>
	</div>
	<div class="row">
		<div id="texto" class="col-sm-6">
			Nacionalidad:
		</div>
		<div id="campo" class="col-sm-6">
			<select id="nacionalidad">
				<option id="mex" selected>Mexicana</option>
			    <option id="nat">Naturalizado</option>
			    <option id="ext">Extranjera</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div id="texto" class="col-sm-6">
			Fecha de nacimiento:
		</div>
		<div id="campo" class="col-sm-6">
			<input class="date form-control fecha" type="text" value="{{$identidad->nacimiento}}" name="f_nac" maxlength="10">
		</div>
	</div>
	<div class="row">
		<div id="texto" class="col-sm-6">
			Lugar de nacimiento:
		</div>
		<div id="campo" class="col-sm-6">
			<div id="paises_mexicano">
				<select>
					@foreach($paises as $pais)
				    	<option value="{{ $pais->pais_cve_ch }}">{{ $pais->pais_nombre }}</option>
				    @endforeach
				</select>
			</div>
			<div id="paises_otro"> 
				<select disabled>
				    <option value=""> </option>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="nacional">
	<div class="row">
		<p><b>Documentación: </b></p>
		<div id="texto" class="col-sm-6">
			Documento de identidad:
		</div>
		<div id="campo" class="col-sm-6">
			ACTA DE NACIMIENTO
		</div>
	</div>
	<div class="row">
		<div id="texto" class="col-sm-6">
			Número de folio:
		</div>
		<div id="campo" class="col-sm-6">
			<input id="num_folio" type="text" class="form-control" name="num_folio" value="" maxlength="" >
		</div>
	</div>
	<div class="row">
		<div id="texto" class="col-sm-3">
			Irregularidad:
		</div>
		<div id="irregularidad" class="col-sm-9">
			<select>
				@foreach($irr_acta as $i_actanac)
			    	<option value="{{ $i_actanac->cat_subcve }}">{{ $i_actanac->cat_nombre }}</option>
			    @endforeach
			</select>
		</div>
	</div>
</div>

@endsection

@section('animaciones')

<script src="{{asset('js/nacionalidad.js')}}"></script>

<script src="{{asset('js/yearpicker.js')}}"></script>

<script src="{{asset('js/datepicker_esp.js')}}"></script>

@endsection