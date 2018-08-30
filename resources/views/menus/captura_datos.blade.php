@extends('layouts.app')
@section('title', 'CONDOC | '.$title)
@section('location')
<div>
	<p id="navegacion">
		<a href="{{ route('home') }}"><i class="fa fa-home" style="font-size:28px"></i></a>  >>
		{{-- <a href="#"><span class="glyphicon glyphicon-home"> </span> --}}
		<a href="{{ url('/datos-personales') }}"> Realizar Revisión de Estudios </a> >>
		<a href="{{ url('/rev_est/'.$num_cta) }}"> {{$title}} </a> </p>
</div>
@endsection
@section('estilos')
	<link href="{{ asset('css/rev_estudios.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/rev_estudios2.css') }}" rel="stylesheet"> --}}

    {{-- Para elegir solo año en opcion de periodo --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
@endsection
@section('content')
		<div>
		<h2 id="titulo">Revisión de Estudios</h2>
		<form class="form-group" method="POST" action="{{ url('/rev_est/'.$num_cta) }}">
			{!! csrf_field() !!}
		<div class="row">
			<div id="instrucciones" class="col-sm-6">Ingresa los datos que se solicitan.</div>
			<div id="firmar" class="col-sm-6">
				<div class="botones">
					<a class="btn btn-default" href="{{ url('/datos-personales') }}" role="">Atrás</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
					<a class="btn btn-danger" href="{{ url('/home') }}" role="">Salir</a>
				</div>
			</div>
		</div>

	<div class="grid-container">
		<div class="item1">
			<img src="data:image/jpge;base64,{{base64_encode( $foto->foto_foto )}}" class="center"/>
		</div>
		<div class="item2">
			<p>{{$num_cta}}</p>
			<p>{{$identidad->nombres}} {{$identidad->apellido1}} {{$identidad->apellido2}}</p>
			<p>Exp. Posgrado: <span name="exp_pos"></span></p>
			<p>Exp. Sistema Incorporado: <span name="exp_inc"></span></p>
		</div>
		<div class="item3">
			<div class="row">
				<div class="col-sm-9">
					<b>Autorizaciones: </b>
				</div>
				<div class="col-sm-3">
					<b>Firmas: </b>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-9">
					Jefe de sección:
					@if($firmas == null || $firmas->jsec_nombre == null)
						<p><i>En espera...</i></p>
					@else
						<p><i>{{ $firmas->jsec_nombre }} | {{ date('d-m-Y', strtotime($firmas->jsec_fecha)) }}</i></p>
					@endif
				</div>
				<div class="col-sm-3">
					@if($firmas == null || $firmas->jsec_nombre == null)
						@if(in_array("JSecc", $roles_us))
							<input type="password" name="jsec_firma" style="width: 70%">
						@else
							<input type="password" name="jsec_firma" style="width: 70%" disabled>
						@endif
					@else
						<span class="fa fa-check-square-o"/>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-sm-9">
					Jefe de área:
					@if($firmas == null || $firmas->jarea_nombre == null)
						<p><i>En espera...</i></p>
					@else
						<p><i>{{ $firmas->jarea_nombre }} | {{ date('d-m-Y', strtotime($firmas->jarea_fecha)) }}</i></p>
					@endif
				</div>
				<div class="col-sm-3">
					@if($firmas == null || $firmas->jarea_nombre == null)
						@if(in_array("JArea", $roles_us))
							<input type="password" name="jarea_firma" style="width: 70%">
						@else
							<input type="password" name="jarea_firma" style="width: 70%" disabled>
						@endif
					@else
						<span class="fa fa-check-square-o"/>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-sm-9">
					Jefe de departamento Rev:
					@if($firmas == null || $firmas->jdepre_nombre == null)
						<p><i>En espera...</i></p>
					@else
						<p><i>{{ $firmas->jdepre_nombre }} | {{ date('d-m-Y', strtotime($firmas->jdepre_fecha)) }}</i></p>
					@endif
				</div>
				<div class="col-sm-3">
					@if($firmas == null || $firmas->jdepre_nombre == null)
						@if(in_array("Jud", $roles_us))
							<input type="password" name="jdepre_firma" style="width: 70%">
						@else
							<input type="password" name="jdepre_firma" style="width: 70%" disabled>
						@endif
					@else
						<span class="fa fa-check-square-o"/>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-sm-9">
					Jefe de departamento Tit:
					@if($firmas == null || $firmas->jdeptit_nombre == null)
						<p><i>En espera...</i></p>
					@else
						<p><i>{{ $firmas->jdeptit_nombre }} | {{ date('d-m-Y', strtotime($firmas->jdeptit_fecha)) }}</i></p>
					@endif
				</div>
				<div class="col-sm-3">
					@if($firmas == null || $firmas->jdeptit_nombre == null)
						@if(in_array("JTit", $roles_us))
							<input type="password" name="jdeptit_firma" style="width: 70%">
						@else
							<input type="password" name="jdeptit_firma" style="width: 70%" disabled>
						@endif
					@else
						<span class="fa fa-check-square-o"/>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-sm-9">
					Dirección:
					@if($firmas == null || $firmas->direccion_nombre == null)
						<p><i>En espera...</i></p>
					@else
						<p><i>{{ $firmas->direccion_nombre }} | {{ date('d-m-Y', strtotime($firmas->direccion_fecha)) }}</i></p>
					@endif
				</div>
				<div class="col-sm-3">
					@if($firmas == null || $firmas->direccion_nombre == null)
						@if(in_array("Direccion", $roles_us))
							<input type="password" name="direccion_firma" style="width: 70%">
						@else
							<input type="password" name="direccion_firma" style="width: 70%" disabled>
						@endif
					@else
						<span class="fa fa-check-square-o"/>
					@endif
				</div>
			</div>
		</div>
		<div class="item4">
			@if($lic->nivel == "L")
				<p class="espe">Plan de estudios: {{$lic->plan_clave}}</p>
				<p>Nivel: LICENCIATURA</p>
			@endif

			<p>Carrera: {{$lic->carrera_nombre}}</p>
			<p>Orientación: {{$lic->plan_nombre}}</p>
		</div>
	</div>
	<div id="c_datos">

		@if ($errors->any())
		    <div id="error" class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		<div class="grid-info">
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
						<select name="sexo">
							@if($identidad->sexo == "FEMENINO")
								<option id="FEMENINO" value="FEMENINO" selected>FEMENINO</option>
							    <option id="MASCULINO" value="MASCULINO">MASCULINO</option>
							@else
								<option id="MASCULINO" value="MASCULINO" selected>MASCULINO</option>
							    <option id="FEMENINO" value="FEMENINO">FEMENINO</option>
							@endif
						</select>
					</div>
				</div>
				<div class="row">
					<div id="texto" class="col-sm-6">
						Nacionalidad:
					</div>
					<div id="campo" class="col-sm-6">
						<select id="nacionalidad" name="nacionalidad">
							@foreach($nacionalidades as $nacion)
								@if($nacion->id_nacionalidad == $identidad->nacionalidad)
									<option id="{{ $nacion->id_nacionalidad }}" value="{{ $nacion->id_nacionalidad }}" selected>{{ $nacion->nacionalidad }}</option>
								@else
									<option id="{{ $nacion->id_nacionalidad }}" value="{{ $nacion->id_nacionalidad }}">{{ $nacion->nacionalidad }}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>
				<div class="row">
					<div id="texto" class="col-sm-6">
						Fecha de nacimiento:
					</div>
					<div id="campo" class="col-sm-6">
						<input class="date form-control fecha datepicker_esp" type="text" value="{{ date('d/m/Y', strtotime( str_replace('/', '-', $identidad->nacimiento))) }}" name="fecha_nac" maxlength="10">
					</div>
				</div>
				<div class="row">
					<div id="texto" class="col-sm-6">
						Lugar de nacimiento:
					</div>
					<div id="campo" class="col-sm-6">
						<div id="paises_mexicano">
							<select name="lugar_nac">
								@foreach($paises as $pais)
								  	@if((int)$pais->pais_cve == $identidad->{'entidad-nacimiento'})
										<option value="{{ (int)$pais->pais_cve }}" selected>{{ $pais->pais_nombre }}</option>
									@else
										<option value="{{ (int)$pais->pais_cve }}">{{ $pais->pais_nombre }}</option>
									@endif
								@endforeach
							</select>
						</div>
						<div id="paises_otro">
							<select name="lugar_nac" disabled>
							    <option> </option>
							</select>
						</div>
					</div>
				</div>
				<hr/>
				<div class="row" id="detalles">
					Información proveniente de: <b>{{$sistema}}</b>
				</div>
			</div>
			<div class="nacional">
				<div class="row">
					<p><b>Documentación: </b></p>
					<div id="texto" class="col-sm-6">
						Documento de identidad:
					</div>
					<div id="campo" class="col-sm-6">
						<span id="acta">ACTA DE NACIMIENTO</span>
						<span id="carta">CARTA DE NATURALIZACIÓN</span>
					</div>
				</div>
				<div class="row">
					<div id="texto" class="col-sm-6">
						Número de folio:
					</div>
					<div id="campo" class="col-sm-6">
						@if(isset($identidad->folio_doc))
							<input id="folio_doc" type="text" class="form-control" name="folio_doc" value="{{ $identidad->folio_doc }}">
						@else
							<input id="folio_doc" type="text" class="form-control" name="folio_doc">
						@endif
					</div>
				</div>
				<div class="row">
					<div id="texto" class="col-sm-3">
						Irregularidad:
					</div>
					<div id="irregularidad" class="col-sm-9">
						<select id="irre_acta" name="irregularidad_doc_act">
							@foreach($irr_acta as $i_actanac)
							  	@if(isset($identidad->irre_doc) && $identidad->irre_doc == $i_actanac->cat_subcve)
									<option value="{{ $i_actanac->cat_subcve }}" selected>{{ $i_actanac->cat_nombre }}</option>
								@else
									<option value="{{ $i_actanac->cat_subcve }}">{{ $i_actanac->cat_nombre }}</option>
								@endif
						    @endforeach
						</select>
						<select id="irre_carta" name="irregularidad_doc_cert">
							@foreach($irr_migr as $i_actanac)
							  	@if($identidad->irre_doc == $i_actanac->cat_subcve)
									<option value="{{ $i_actanac->cat_subcve }}" selected>{{ $i_actanac->cat_nombre }}</option>
								@else
									<option value="{{ $i_actanac->cat_subcve }}">{{ $i_actanac->cat_nombre }}</option>
								@endif
						    @endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="academica">
				<p>
					<b>Escuelas de procedencia: </b>
					<scan id="esc_proc">
						@if($firmas == null || $firmas->actualizacion_nombre == null)
							<a class="btn btn-default" id="agregar_esc" disabled>Agregar escuela</a>
							<a class="btn btn-default" id="quitar_esc" disabled>Quitar escuela</a>
						@else
							<a class="btn btn-default" id="agregar_esc" href="{{ url('/agregar_esc/'.$num_cta) }}" target="_self">Agregar escuela</a>
							<a class="btn btn-default" id="quitar_esc" href="{{ url('/quitar_esc/'.$num_cta) }}" target="_self">Quitar escuela</a>
						@endif
					</scan>
				</p>
				<div id="re_historial">

			      	<ul class="nav nav-tabs">
			      		@foreach($escuelas as $tyt)
			      			@if($tyt == $trayectoria->situaciones[0])
			        			<li class="active"><a data-toggle="tab" href="#<?=$tyt->nivel?>" name="niveles[]">{{ $tyt->nivel }}</a></li>
			        		@else
			        			<li><a data-toggle="tab" href="#<?=$tyt->nivel?>" name="niveles[]">{{ $tyt->nivel }}</a></li>
			        		@endif
			        	@endforeach
			      	</ul>

			      	<div id="folder" class="tab-content">
			      		@foreach($escuelas as $tyt)
				      		@if($tyt == $trayectoria->situaciones[0])
	        					<div id="<?=$tyt->nivel?>" class="tab-pane fade in active">
	        				@else
	        					<div id="<?=$tyt->nivel?>" class="tab-pane fade">
	        				@endif

	        					{{-- {{ count($escuelas)}} --}}
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Tipo escuela de procedencia:
						      		</div>
								    <div id="campo" class="col-sm-6" name="tipo_esc">
										tipo
								    </div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Escuela de procedencia:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<input id="e_procedencia" type="text" class="form-control" name="escuela_proc[]" value="{{ $tyt->plantel_nombre }}">
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Clave:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<input id="cct" type="text" class="form-control" name="cct[]" value="{{ $tyt->plantel_clave }}">
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Entidad:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<select name="entidad_esc[]">
						      			    @foreach($paises as $pais)
						    					<option value="{{ (int)$pais->pais_cve }}">{{ $pais->pais_nombre }}</option>
						    				@endforeach
						      			</select>
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Folio de certificado:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			@if(isset($tyt->folio_cert))
						      				<input id="folio_cert" type="text" class="form-control" name="folio_cert[]" value="{{ $tyt->folio_cert }}">
						      			@else
						      				<input id="folio_cert" type="text" class="form-control" name="folio_cert[]">
						      			@endif
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			<select id="seleccion_periodo" name="seleccion_fecha[]">
						      				@if(isset($tyt->seleccion_fecha) && $tyt->seleccion_fecha == 0)
						      					<option id="periodo" name="periodo" value="0" selected>Periodo de expedición</option>
						      			    	<option id="mes_anio" name="mes_anio" value="1">Fecha de expedición</option>
						      			    @else
						      			    	<option id="periodo" name="periodo" value="0">Periodo de expedición</option>
						      			    	<option id="mes_anio" name="mes_anio" value="1" selected>Fecha de expedición</option>
						      			    @endif
						      			</select>
								    </div>
								    <div id="campo" class="col-sm-6">
								    	<div id="periodo_show">
								    		De
								    		@if(isset($tyt->inicio_periodo))
								    			<input name="inicio_periodo[]" type="text" class="yearpicker" value="{{$tyt->inicio_periodo}}" style="width: 41%"/>
						      				@else
						      					<input name="inicio_periodo[]" type="text" class="yearpicker" style="width: 41%"/>
						      				@endif
								    		 a
								    		@if(isset($tyt->fin_periodo))
								    			<input name="fin_periodo[]" type="text" class="yearpicker" value="{{$tyt->fin_periodo}}" style="width: 41%"/>
						      				@else
						      					<input name="fin_periodo[]" type="text" class="yearpicker" style="width: 41%"/>
						      				@endif
								    	</div>
								    	<div id="mes_anio_show">
								    		@if(isset($tyt->mes_anio))
								    			<input class="date form-control fecha" type="text" name="mes_anio[]" value="{{ date('d/m/Y', strtotime( str_replace('/', '-', $tyt->mes_anio))) }}" maxlength="10">
								    		@else
								    			<input class="date form-control fecha" type="text" name="mes_anio[]" maxlength="10">
								    		@endif
								    	</div>
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Promedio:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			@if(isset($tyt->promedio))
						      				<input id="promedio" type="text" class="form-control" name="promedio[]" value="{{$tyt->promedio}}" maxlength="5" >
						      			@else
						      				<input id="promedio" type="text" class="form-control" name="promedio[]" maxlength="5" >
						      			@endif
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-3">
						      			Irregularidad:
						      		</div>
						      		<div id="irregularidad" class="col-sm-9">
						      			<select name="irregularidad_esc[]">
						      				@foreach($irr_cert as $i_certificado)
						      				  	@if(isset($tyt->irre_cert) && $tyt->irre_cert == $i_certificado->cat_subcve)
						      						<option value="{{ $i_certificado->cat_subcve }}" selected>{{ $i_certificado->cat_nombre }}</option>
						      					@else
						      						<option value="{{ $i_certificado->cat_subcve }}">{{ $i_certificado->cat_nombre }}</option>
						      					@endif
						      				@endforeach
						      			</select>
						      		</div>
						      	</div>
						      	<hr/>
						      	<div class="row" id="detalles">
						      		Información proveniente de: <b>{{$tyt->sistema_escuela}}</b>
						      	</div>
						    </div>
					    @endforeach
			        </div>

			    </div>
			</div>
		</div>

	</div>
</form>

</div>

@endsection

@section('animaciones')

    {{-- Para bloquear el campo de entidad de nacimiento en caso de no ser mexicano --}}
    <script src="{{asset('js/nacionalidad.js')}}"></script>

    {{-- Para escuelas de procedencias --}}
    <script src="{{asset('js/qescuela_procedencia.js')}}"></script>

    {{-- Para elegir fecha en español --}}
    <script src="{{asset('js/datepicker_esp.js')}}"></script>

    {{-- Para elegir solo año en opcion de periodo --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{asset('js/yearpicker.js')}}"></script>

    {{-- Para mostrar irregularidades dada la nacionalidad del alumno --}}
    <script>
    	$(function() {
    	  $("#nacionalidad").change(function() {
    	    if ($("#1").is(":selected") || $("#3").is(":selected")) {
    	      $("#acta").show();
    	      $("#irre_acta").show();
    	      $("#carta").hide();
    	      $("#irre_carta").hide();
    	    } else {
    	      $("#acta").hide();
    	      $("#irre_acta").hide();
    	      $("#carta").show();
    	      $("#irre_carta").show();
    	    }
    	  }).trigger('change');
    	});
    </script>

    {{-- Para mostrar el campo correspondiente para mes-año según corresponda |||| Corregir --}}
    {{-- <script src="{{asset('js/aniomes.js')}}"></script> --}}
    <script>
    	var value = $("[id='seleccion_periodo']");
    	value.forEach($(function() {
    		$("#seleccion_periodo").change(function() {
    	    	if ($("#periodo").is(":selected")) {
    	      	$("#periodo_show").show();
    	      	$("#mes_anio_show").hide();
    	    } else {
    	    	$("#periodo_show").hide();
    	    	$("#mes_anio_show").show();
    	    }
    	}).trigger('change');
    	}));
    	/*value.forEach($(function() {
    		$("#seleccion_periodo").change(function() {
    	    	if ($("#periodo").is(":selected")) {
    	      	$("[id=periodo_show]").show();
    	      	$("[id=mes_anio_show]").hide();
    	    } else {
    	    	$("#periodo_show").hide();
    	    	$("#mes_anio_show").show();
    	    }
    	}).trigger('change');
    	}));*/
    </script>

@endsection
