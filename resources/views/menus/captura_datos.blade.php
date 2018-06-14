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

	<h2 id="titulo">Revisión de Estudios</h2>
	<div id="instrucciones">Ingresa los datos que se solicitan.
		<div id="firmar">
			<div>
				<label>Firma: </label>
				<input type="text" name="firma" id="firma" class="form-control" name="firma" value="" required>
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
			<p>Plan de estudios: {{$trayectoria->situaciones[1]->plantel_clave}}</p>
			@if($trayectoria->situaciones[1]->nivel == "B")
				<p>Nivel: BACHILLERATO</p>
			@elseif($trayectoria->situaciones[1]->nivel == "L")
				<p>Nivel: LICENCIATURA</p>
			@else
				<p>Nivel: </p>
			@endif

			<p>Carrera: {{$trayectoria->situaciones[1]->carrera_nombre}}</p>
			<p>Orientación: Orientación</p>
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
						<select>
						    <option value="mexa">Mexicana</option>
						    <option value="can">Canadiense</option>
						    <option value="ame">Americana</option>
						    <option value="rus" selected>Rusa</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div id="texto" class="col-sm-6">
						Fecha de nacimiento:
					</div>
					<div id="campo" class="col-sm-6">
						<input class="date form-control" type="text" value="{{$identidad->nacimiento}}" name="f_nac" maxlength="10">
					</div>
				</div>
				<div class="row">
					<div id="texto" class="col-sm-6">
						País de nacimiento:
					</div>
					<div id="campo" class="col-sm-6">
						<select>
						    <option value="mexa">México</option>
						    <option value="can">Canadá</option>
						    <option value="ame">USA</option>
						    <option value="rus" selected>Rusa</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div id="texto" class="col-sm-6">
						Estado de nacimiento:
					</div>
					<div id="campo" class="col-sm-6">
						<select>
						    <option value="mexa">México</option>
						    <option value="can">CDMX</option>
						    <option value="ame">Guerrero</option>
						    <option value="rus" selected>Aguascalientes</option>
						</select>
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
						<select>
						    <option value="mexa">Acta de nacimiento</option>
						    <option value="can">Otro1</option>
						    <option value="ame">Otro2</option>
						    <option value="rus" selected>Otro3</option>
						</select>
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
						<button class="btn btn-basic">Agregar escuela</button>
						<button class="btn btn-basic">Quitar escuela</button>
					</scan>
				</p>
				<div id="re_historial">

			      	<ul class="nav nav-tabs">
			      		@foreach($trayectoria->situaciones as $tyt)
			      			@if($tyt == $trayectoria->situaciones[0])
			        			<li class="active"><a data-toggle="tab" href="#<?=$tyt->nivel?>">{{ $tyt->nivel }}</a></li>
			        		@else	
			        			<li><a data-toggle="tab" href="#<?=$tyt->nivel?>">{{ $tyt->nivel }}</a></li>
			        		@endif
			        	@endforeach
			      	</ul>

			      	<div id="folder" class="tab-content">
			      		@foreach($trayectoria->situaciones as $tyt)
				      		@if($tyt == $trayectoria->situaciones[0])
	        					<div id="<?=$tyt->nivel?>" class="tab-pane fade in active">
	        				@else
	        					<div id="<?=$tyt->nivel?>" class="tab-pane fade">
	        				@endif

						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Nivel de escuela de procedencia:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<select>
						      			    <option value="mexa">Preparatoria</option>
						      			    <option value="can">Licenciatura</option>
						      			    <option value="ame">Otro1</option>
						      			    <option value="rus" selected>Otro2</option>
						      			</select>
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
						      			País:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<select>
						      			    <option value="mexa">México</option>
						      			    <option value="can">Corea</option>
						      			    <option value="ame">China</option>
						      			    <option value="rus" selected>Japón</option>
						      			</select>
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Estado:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			<select>
						      			    <option value="mexa">Uno</option>
						      			    <option value="can">Dos</option>
						      			    <option value="ame">Tres</option>
						      			    <option value="rus" selected>Cuatro</option>
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
						      			<input class="date form-control" type="text">
						      		</div>
						      	</div>
						      	<div class="row">
						      		<div id="texto" class="col-sm-6">
						      			Periodo:
						      		</div>
						      		<div id="campo" class="col-sm-6">
						      			De <input type="text" class="datepicker" style="width: 43%"/>
						      			 a 
						      			<input type="text" class="datepicker" style="width: 43%"/>
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