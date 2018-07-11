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
			<img src="{{ asset('images/foto.png') }}" class="center">
		</div>
		<div class="item2">
			<p name="num_cta">{{$num_cta}}</p>
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
							<input type="password" name="jdeptit_firma" style="width: 70%">
						@else
							<input type="password" name="jdeptit_firma" style="width: 70%" disabled>
						@endif
					@else
						<span class="fa fa-check-square-o"/>
					@endif
				</div>
			</div>
		</div>
		<div class="item4">
			<p class="espe">Plan de estudios: {{$trayectoria->situaciones[$num_situaciones]->plantel_clave}}</p>
			@if($trayectoria->situaciones[$num_situaciones]->nivel == "B")
				<p>Nivel: BACHILLERATO</p>
			@elseif($trayectoria->situaciones[$num_situaciones]->nivel == "L")
				<p>Nivel: LICENCIATURA</p>
			@else
				<p>Nivel: </p>
			@endif

			<p>Carrera: {{$trayectoria->situaciones[$num_situaciones]->carrera_nombre}}</p>
			<p>Orientación: {{$trayectoria->situaciones[$num_situaciones]->plan_nombre}}</p>
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
								<option id="{{ $nacion->id_nacionalidad }}" value="{{ $nacion->id_nacionalidad }}">{{ $nacion->nacionalidad }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row">
					<div id="texto" class="col-sm-6">
						Fecha de nacimiento:
					</div>
					<div id="campo" class="col-sm-6">
						<input class="date form-control fecha datepicker_esp" type="text" value="{{$identidad->nacimiento}}" name="fecha_nac" maxlength="10">
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
							    	<option value="{{ $pais->pais_cve }}">{{ $pais->pais_nombre }}</option>
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
			</div>
			<div class="nacional">
				<div class="row">
					<p><b>Documentación: </b></p>
					<div id="texto" class="col-sm-6">
						Documento de identidad:
					</div>
					<div id="campo" class="col-sm-6">
						<span name="documento_identidad">ACTA DE NACIMIENTO</span>
					</div>
				</div>
				<div class="row">
					<div id="texto" class="col-sm-6">
						Número de folio:
					</div>
					<div id="campo" class="col-sm-6">
						<input id="folio_doc" type="text" class="form-control" name="folio_doc">
					</div>
				</div>
				<div class="row">
					<div id="texto" class="col-sm-3">
						Irregularidad:
					</div>
					<div id="irregularidad" class="col-sm-9">
						<select name="irregularidad_doc">
							@foreach($irr_acta as $i_actanac)
						    	<option value="{{ $i_actanac->cat_subcve }}">{{ $i_actanac->cat_nombre }}</option>
						    @endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="academica">
				<p>
					<b>Escuelas de procedencia: </b>
					<scan id="esc_proc">
						<a class="btn btn-default" id="agregar_esc" role="" href="{{ url('/agregar_esc/'.$num_cta) }}" target="_self">Agregar escuela</a>
						<a class="btn btn-default" id="quitar_esc" role="" href="{{ url('/agregar_esc/'.$num_cta) }}" target="_self">Quitar escuela</a>
					</scan>
				</p>
				<div id="re_historial">

			      	<ul class="nav nav-tabs">
			      		@foreach($escuelas as $tyt)
			      			@if($tyt == $trayectoria->situaciones[0])
			        			<li class="active"><a data-toggle="tab" href="#<?=$tyt->nivel?>">{{ $tyt->nivel }}</a></li>
			        		@else
			        			<li><a data-toggle="tab" href="#<?=$tyt->nivel?>">{{ $tyt->nivel }}</a></li>
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
						    					<option value="{{ $pais->pais_cve }}">{{ $pais->pais_nombre }}</option>
						    				@endforeach
						      			</select>
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Folio de certificado:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<input id="folio_cert" type="text" class="form-control" name="folio_cert[]">
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			<select id="seleccion_periodo" name="seleccion_fecha[]">
						      				<option id="periodo" name="periodo" selected>Periodo de expedición</option>
						      			    <option id="mes_anio" name="mes_anio">Fecha de expedición</option>
						      			</select>
								    </div>
								    <div id="campo" class="col-sm-6">
								    	<div id="periodo_show">
								    		De <input name="inicio_periodo[]" type="text" class="yearpicker" style="width: 41%"/>
								    		 a 
								    		<input name="fin_periodo[]" type="text" class="yearpicker" style="width: 41%"/>
								    	</div>
								    	<div id="mes_anio_show"> 
								    		<input class="date form-control fecha" type="text" name="mes_anio[]" maxlength="10">
								    	</div>
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Promedio:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<input id="promedio" type="text" class="form-control" name="promedio[]" value="" maxlength="5" >
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-3">
						      			Irregularidad:
						      		</div>
						      		<div id="irregularidad" class="col-sm-9">
						      			<select name="irregularidad_esc[]">
						      				@foreach($irr_cert as $i_certificado)
						      				   	<option value="{{ $i_certificado->cat_subcve }}">{{ $i_certificado->cat_nombre }}</option>
						      				@endforeach
						      			</select>
						      		</div>
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
