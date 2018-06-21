@extends('layouts.app')
@section('title', 'CONDOC | Revisión de Estudios')

@section('location')
<div style="padding-top: 1%">
	<p id="navegacion">
		<a href="{{ url('/home') }}"><span class="glyphicon glyphicon-home"></span>
		<span> </span> Licenciatura </a> >> 
		<a href="{{ url('/datos_personales') }}"> Revisión de Estudios </a> </p>
</div>
@endsection

@section('content')
	
	<div>
	<form class="form-group" method="POST" action="{{ url('/rev_est/'.$num_cta) }}">
		{!! csrf_field() !!}

		{{dd($identidad)}}

	<h2 id="titulo">Revisión de Estudios</h2>
	<div id="instrucciones">Ingresa los datos que se solicitan.
		<div id="firmar">
			<div>
				<label>Firma: </label>
				<input type="text" name="firma" id="firma" class="form-control" name="firma" value="">
			</div>
			<div>
				<button id="guardar" type="submit" class="btn btn-primary">
				   	Firmar
				</button>
				<a id="volver" class="btn btn-danger" href="{{ url('/home') }}" role="button">Salir</a>
			</div>
		</div>
	</div>

	<div class="grid-container">
		<div class="item1">
			<img src="{{ asset('images/foto.png') }}" class="center">
		</div>
		<div class="item2">
			<p>{{$num_cta}}</p>
			<p>{{$identidad->nombres}} {{$identidad->apellido1}} {{$identidad->apellido2}}</p>
			<p>Exp. Posgrado: </p>
			<p>Exp. Sistema Incorporado: </p>
		</div>
		<div class="item3">
			<div class="row">
				<p><b>Autorizaciones: </b></p>
				<div class="col-sm-10">
					Oficinista:
					<p>NombreA ApellidoA ApellidoDosA <span>dd-mm-aaaa</span></p>
				</div>
				<div class="col-sm-2">
					<span class="glyphicon glyphicon-check">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-10">
					Jefe de sección: 
					<p>NombreB ApellidoB ApellidoDosB <span>dd-mm-aaaa</span></p>
				</div>
				<div class="col-sm-2">
					<span class="glyphicon glyphicon-check">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-10">
					Jefe de área:
					<p>NombreC ApellidoC ApellidoDosC <span>dd-mm-aaaa</span></p> 
				</div>
				<div class="col-sm-2">
					<span class="glyphicon glyphicon-check">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-10">
					Jefe de departamento:
					<p>NombreD ApellidoD ApellidoDosD</p> 
				</div>
				<div class="col-sm-2">
					<span class="glyphicon glyphicon-time">
				</div>
			</div>
		</div>
		<div class="item4">
			<p>Plan de estudios: {{$trayectoria->situaciones[$num_situaciones-1]->plantel_clave}}</p>
			@if($trayectoria->situaciones[$num_situaciones-1]->nivel == "B")
				<p>Nivel: BACHILLERATO</p>
			@elseif($trayectoria->situaciones[$num_situaciones-1]->nivel == "L")
				<p>Nivel: LICENCIATURA</p>
			@else
				<p>Nivel: </p>
			@endif

			<p>Carrera: {{$trayectoria->situaciones[$num_situaciones-1]->carrera_nombre}}</p>
			<p>Orientación: {{$trayectoria->situaciones[$num_situaciones-1]->plan_nombre}}</p>
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
			<div class="academica">
				<p>
					<b>Escuelas de procedencia: </b>
					<scan id="esc_proc">
						<a class="btn btn-default" id="agregar_esc" role="">Agregar escuela</a>
						<a class="btn btn-default" id="quitar_esc" role="">Quitar escuela</a>

						<!-- The Modal -->
						<div id="modal_agregar" class="modal">

						  <!-- Modal content -->
						  <div class="modal-content">
						    <span class="close">&times;</span>
						    <div class="row">
						    	<div class="col-sm-4">
						    		Número de cuenta:
						    	</div>
						    	<div class="col-sm-8">
						    		<input id="num" type="text" name="num_accion" value="{{$num_cta}}" maxlength="">
						    	</div>
						    </div>
						    <div class="row">
						    	<div class="col-sm-4">
						    		Nivel escuela:
						    	</div>
						    	<div class="col-sm-8">
						    		<select>
						    			<option value="fem" selected>Femenino</option>
						    		    <option value="mas">Masculino</option>
						    		</select>
						    	</div>
						    </div>
						    <div class="row">
						    	<div class="col-sm-4">
						    		Plan carrera:
						    	</div>
						    	<div class="col-sm-8">
						    		<select>
						    			<option value="fem" selected>Femenino</option>
						    		    <option value="mas">Masculino</option>
						    		</select>
						    	</div>
						    </div>
						  </div>

						</div>

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

	        					{{ count($escuelas)}}

						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Tipo escuela de procedencia:
						      		</div>
								    <div id="campo" class="col-sm-6">
										tipo
								    </div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Escuela de procedencia:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<input id="e_procedencia" type="text" class="form-control" name="e_procedencia" value="{{ $tyt->plantel_nombre }}">
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Clave:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<input id="cct" type="text" class="form-control" name="cct" value="{{ $tyt->plantel_clave }}" maxlength="">
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Entidad:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<select>
						      			    @foreach($paises as $pais)
						    					<option value="{{ $pais->pais_cve_ch }}">{{ $pais->pais_nombre }}</option>
						    				@endforeach
						      			</select>
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Folio de certificado:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<input id="folio_cert" type="text" class="form-control" name="folio_cert" value="" maxlength="" >
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Fecha expedición:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<input class="date form-control fecha" type="text">
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			<select id="seleccion_periodo">
						      				<option id="periodo" selected>Periodo</option>
						      			    <option id="mes_anio">Mes-Año</option>
						      			</select>
								    </div>
								    <div id="campo" class="col-sm-6">
								    	<div id="periodo_show">
								    		De <input type="text" class="yearpicker" style="width: 41%"/>
								    		 a 
								    		<input type="text" class="yearpicker" style="width: 41%"/>
								    	</div>
								    	<div id="mes_anio_show"> 
								    		<input class="date form-control fecha" type="text" value="" name="f_esc" maxlength="10">
								    	</div>
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Promedio:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<input id="promedio" type="text" class="form-control" name="promedio" value="" maxlength="5" >
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-3">
						      			Irregularidad:
						      		</div>
						      		<div id="irregularidad" class="col-sm-9">
						      			<select>
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
    {{-- Para el uso del datepicker --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('js/datepicker.js')}}"></script>

    {{-- Para bloquear el campo de entidad de nacimiento en caso de no ser mexicano --}}
    <script src="{{asset('js/nacionalidad.js')}}"></script>

    {{-- Para escuelas de procedencias --}}
    <script src="{{asset('js/aescuela_procedencia.js')}}"></script>
    <script src="{{asset('js/qescuela_procedencia.js')}}"></script>

    {{-- Para mostrar el campo correspondiente para mes-año según corresponda |||| Corregir --}}
    <script src="{{asset('js/aniomes.js')}}"></script>

    {{-- Para elegir año en opcion de periodo |||| No funcional --}}
    <script src="{{asset('js/yearpicker.js')}}"></script>

    {{-- Para elegir fecha en español --}}
    <script src="{{asset('js/datepicker_esp.js')}}"></script>
@endsection