@extends('menus.numero_cuenta')
@section('esp', $title)

@section('ruta')
<form class="form-group solicitud" method="POST" action="{{ url( '/re_dictamenes') }}">
@endsection
@section('estilos')
<link href="{{ asset('css/rev_estudios.css') }}" rel="stylesheet">
@endsection
@section('info-alumno')

	@if(isset($num_cta))
	@if($condoc_personal != NULL)
	<table style="width: 100%">
		<tr>
		<td><a onclick="f_izq()"><img class="f_izquierda" src="{{ asset('images/flecha_izquierda.png') }}" /></a></td>
		<td>
			<div>
			@foreach($condoc_tyt as $key=>$value)
			@if($key == 0)
				<div id="{{$key}}" class="info-dictamen">
			@else
				<div id="{{$key}}" class="info-dictamen" style="display:none;">
			@endif
			<table style="width: 100%">
				<tr>
					<td>Número de cuenta: </td>
					<td><b>{{$condoc_personal[0]->num_cta}}</b></td>
					<td></td>
					<td class="der"><a class="btn btn-danger" href="{{ route('home') }}" role="button">Salir</a>
					<button class="btn btn-primary waves-effect waves-light" onclick="showDiv()">
			  			Seleccionar
					</button></td>
				</tr>
				<tr>
					<td>Nombre: </td>
					<td><b>{{$condoc_personal[0]->primer_apellido}} * {{$condoc_personal[0]->segundo_apellido}} * 
						{{$condoc_personal[0]->nombre_alumno}}</b></td>
					<td>Sexo: <b>{{$condoc_personal[0]->sexo}}</b></td>
					<td>Fecha Nac: <b>{{date('d/m/Y', strtotime(str_replace('/', '-', $condoc_personal[0]->fecha_nacimiento)))}}</b></td>
				</tr>
				<tr>
					@foreach($nacionalidades as $nacion)
						@if($nacion->id_nacionalidad == $condoc_personal[0]->id_nacionalidad)
							<td>Nacionalidad: <b>{{$nacion->nacionalidad}}</b></td>
						@endif
					@endforeach
					@foreach($paises as $pais)
						@if($pais->pais_cve == $condoc_personal[0]->pais_cve)
							<td>Entidad Nacimiento: <b>{{$pais->pais_nombre}}</b></td>
						@endif
					@endforeach
				</tr>
				<tr>
					<td>Sit Escolar: <b>Inscrito</b></td>
					@if($condoc_tyt[$key]->seleccion_fecha == 0)
						<td>Año Ingreso: <b>{{$condoc_tyt[$key]->inicio_periodo}}</b></td>
					@else
						<td>Fecha de Ingreso: <b>{{date('d/m/Y', strtotime(str_replace('/', '-', $condoc_tyt[$key]->mes_anio)))}}</b></td>
					@endif
					<td>Tipo Ingreso: </td> 
					<td><b>{{$condoc_tyt[$key]->tipo_ingreso}}</b></td>
				</tr>
				<tr>
					<td>Carrera/Programa: </td>
					@if($condoc_tyt[$key]->nivel == "L")
						<td><b>{{$condoc_lic[0]->nombre_planestudios}}</b></td>
					@else
						<td><b>Algo</b></td>
					@endif
				</tr>
				<tr>
					<td>Plantel: </td>
					<td><b>{{$condoc_tyt[$key]->nombre_escproc}}</b></td>
				</tr>
				<tr>
					<td>Orientación: </td>
					<td><b>{{$condoc_tyt[$key]->nombre_plan}}</b></td>
				</tr>
				<tr>
					@foreach($niveles as $nivel)
						@if($nivel->id_nivel == $condoc_tyt[$key]->nivel)
							<td>Nivel: <b>{{$nivel->nombre_nivel}}</b></td>
						@endif
					@endforeach
					<td>Sistema: <b>Algo2</b></td>
				</tr>
			</table>
		</div>
		@endforeach
		</div>
		</td>
		<td><a onclick="f_der()"><img class="f_derecha" src="{{ asset('images/flecha_derecha.png') }}" /></a></td>
		</tr>
		<tr>
		<td></td>
		<td><div id="tramite-dictamen" style="display:none;" class="tramite-dictamen">
			<table style="width: 100%">
				<tr>
					<td>Trámites</td>
					<td>Fecha solicitud</td>
					<td></td>
					<td>Oficina</td>
					<td>Fecha Dictámen</td>
					<td></td>
				</tr>
				<tr>
					<td>
						<select name="tramite">
							@foreach($tramites as $t)
								<option value="{{ $t->id_tramite }}">{{$t->nombre_tramite}}</option>
							@endforeach
						</select>
					</td>
					<td><p><input id="f_depre" name="f_depre" value=""><input type="button" onclick="showDate('f_depre')"/></p></td>
					<td></td>
					<td>
						<select name="oficina">
							@foreach($oficinas as $ofi)
								<option value="{{ $ofi->id_oficina }}">{{$ofi->nombre_oficina}}</option>
							@endforeach
						</select>
					</td>
					<td><p><input id="f_dictamen" name="f_dictamen" value=""><input type="button" onclick="showDate('f_dictamen')"/></p></td>
					<td><input type="submit" class="btn btn-primary waves-effect waves-light" name="submit" value="guardar">
					    	Guardar
					</input></td>
					<td></td>
				</tr>
			</table>
		</div></td>
		</tr>
		</table>
		<br><br><br>
	@else
		<div class="info-error"><b>No es posible realizar el proceso.</b></div>
		<br><br><br>
	@endif
	@endif
@endsection

@section('animaciones')
	
	{{-- Para el flecha derecha --}}
	<script>
		function f_der(){
			//var n = $condoc_tyt;
			var num = <?php echo json_encode($title); ?>;
			if($('#0').css('display') == 'none'){
		  		alert(":D");// Acción si el elemento no es visible
		  	}else{
		  		alert("Total: "+num);// Acción si el elemento es visible
		  	}
			/*var actual = 0; //Hacemos el actual el visible
		  	if($('#'.actual).css('display') == 'none'){
		  		// Acción si el elemento no es visible
		  	}else{
		  		//alert("Total: ");// Acción si el elemento es visible
		  		document.getElementById(actual).style.display = "none";//Ocultamos el actual
		  		document.getElementById(actual+1).style.display = "block";//Hacemos visible el siguiente (actual+1)mod(long)
		  		//actual = actual+1;//Hacemos actual al nuevo visible
		  	}*/
		}
	</script>
	
	{{-- Para capturar datos --}}
	<script src="{{asset('js/mostrar.js')}}"></script>

	{{-- Para obtener la fecha actual --}}
	<script src="{{asset('js/fecha_dictamenes.js')}}"></script>
@endsection