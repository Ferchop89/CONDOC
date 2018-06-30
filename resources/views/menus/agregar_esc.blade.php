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
				<select id="seleccion_nivel" name="nivel_escuela">
					@foreach($nombres_nivel as $nvl)
						<option id="{{ $nvl->id_nivel }}" value="{{ $nvl->id_nivel }}" selected>{{ $nvl->nombre_nivel }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6" id="texto1">
				Plan carrera
			</div>
			<div class="col-sm-6" id="campo1">
				<div id="nivel_mas">
					<select name="plan">
					    <option id="selected_plan"> </option>
					</select>
				</div>
				<div id="niveles_otro"> 
					<select disabled>
					    <option value=""> </option>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6" id="texto1">
				Nombre escuela:
			</div>
			<div class="col-sm-6" id="campo1">
				<select>
					<option id="selected_sch" name="nombre_escuela"> </option>
				</select>
				<p></p>
			</div>
		</div>

		<div class="botones">
			<a class="btn btn-danger" href="{{ url('/rev_est/'.$num_cta) }}" role="button">Volver</a>
			<button type="submit" class="btn btn-primary waves-effect waves-light">
			  	Agregar
			</button>
		</div>
	</form>
</div>
@endsection

@section('animaciones')

	{{-- Para escuelas de procedencias --}}
    <script src="{{asset('js/aescuela_procedencia.js')}}"></script>

	{{-- Para mostrar opciones de escuela --}}
	<script>
		function ssch() {
			var escuelas = <?php echo json_encode($escuelas); ?>;
		  	var inputvalue = $( "#seleccion_nivel" ).val();
		  	escuelas.forEach(function(escuela){
		  		if(escuela.nivel == inputvalue){
		  			$('#selected_plan').text(escuela.plan_nombre);
		  			$('#selected_plan').val(escuela.plan_nombre);
		  			$('#selected_sch').text(escuela.plantel_nombre);
		  			$('#selected_sch').val(escuela.plantel_nombre);
		  		}
		  	});
		}
		 
		$( "select" ).change( ssch );
		ssch();
	</script>

@endsection