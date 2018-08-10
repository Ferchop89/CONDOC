@extends('menus.numero_cuenta')
@section('esp', $title)

@section('ruta')
<form class="form-group solicitud" method="POST" action="{{ url( '/re_dictamenes') }}">
@endsection
@section('estilos')
<link href="{{ asset('css/rev_estudios.css') }}" rel="stylesheet">
<link rel="stylesheet" href="dist/css/slider-pro.min.css"/>
@endsection
@section('info-alumno')

	@if(isset($num_cta))
	<table style="width: 100%">
		<tr>
		<td><a href="#" class="f_izq"><img class="f_izquierda" src="{{ asset('images/flecha_izquierda.png') }}" /></a></td>
		<td>
			<div class="slider-pro" id="carrusel">
			@foreach($condoc_tyt as $key=>$value)
			<div class="info-dictamen sp-slides" id="product_".{{$key}}>
			<div class="sp-slide">
			<table style="width: 100%">
				<tr>
					<td>Número de cuenta: </td>
					<td><b>{{$condoc_personal[0]->num_cta}}</b></td>
					<td></td>
					<td class="der"><a class="btn btn-danger" href="{{ route('home') }}" role="button">Salir</a>
					<button type="submit" class="btn btn-primary waves-effect waves-light" onclick="showDiv()">
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
		</div>
		@endforeach
		</div>
		</td>
		<td><a href="#" class="f_der"><img class="f_derecha" src="{{ asset('images/flecha_derecha.png') }}" /></a></td>
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
						<select>
							@foreach($tramites as $t)
								<option value="{{ $t->id_tramite }}">{{$t->nombre_tramite}}</option>
							@endforeach
						</select>
					</td>
					<td><p><input id="f_depre" name="f_depre"><input type="button" onclick="showDate()"/></p></td>
					<td></td>
					<td>
						<select>
							@foreach($oficinas as $ofi)
								<option value="{{ $ofi->id_oficina }}">{{$ofi->nombre_oficina}}</option>
							@endforeach
						</select>
					</td>
					<td><p><input id="f_dictamen" name="f_dictamen"><input type="button" onclick="showDate()"/></p></td>
					<td><button type="submit" class="btn btn-primary waves-effect waves-light" onclick="showDiv()">
			  			Guardar
					</button></td>
					<td></td>
				</tr>
			</table>
		</div></td>
		</tr>
		</table>
		<br><br><br> 
	@endif
@endsection

@section('animaciones')
	
	{{-- Para el carrusel --}}
	<script src="libs/js/jquery-1.11.0.min.js"></script>
	<script src="dist/js/jquery.sliderPro.min.js"></script>
	<script type="text/javascript">
		jQuery( document ).ready(function( $ ) {
			$( '#carrusel' ).sliderPro();
		});
	</script>
	
	{{-- Para capturar datos --}}
	<script>
		function showDiv() {
		   document.getElementById('tramite-dictamen').style.display = "block";
		}
	</script>

	{{-- Para obtener la fecha actual --}}
	<script>
		function showDate() {
			var hoy = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1;
			var yyyy = today.getFullYear();

			if(dd<10) {
			    dd = '0'+dd
			} 
			if(mm<10) {
			    mm = '0'+mm
			} 

			hoy = mm + '/' + dd + '/' + yyyy;
			document.getElementById('f_depre').value = hoy;
			document.getElementById('f_depre').setAttribute('value', hoy);
			document.getElementById('f_dictamen').value = hoy;
			document.getElementById('f_dictamen').setAttribute('value', hoy);
		}
	</script>
@endsection