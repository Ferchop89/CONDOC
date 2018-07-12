@extends('menus.numero_cuenta')
{{-- @section('title', 'CONDOC | ) --}}
@section('esp', $title)
@section('sub-estilos')
    <link href="{{ asset('css/recepcion.css') }}" rel="stylesheet">
@endsection
@section('ruta')
    <form class="form-group solicitud" method="POST" action="{{ route("postRecepcion") }}">
@endsection

@section('info-alumno')
{{-- {{dd($datos)}} --}}
    @if(isset($datos['sistema']))
        <div class="info-alumno">
            <div class="control">
                <div class="panel-control">
                </div>
                <div class="fila">
                    <div class="dato num_cta">
                        <span>No. Cuenta: <p>{{$datos['num_cta']}}</p></span>
                    </div>
                    @if ($datos['sistema'] == 'DGIRE')
                        <div class="dato expediente">
                            <span>Expediente SI: <p>000000000</p></span>
                        </div>
                    @endif
                    <div class="dato tramite">
                        <span>Tipo Tramite: <p>DESCENTRALIZACIÓN</p></span>
                    </div>
                </div>
                <div class="fila">
                    <div class="dato nombre">
                        <span>Nombre: <p>{{$datos['app']."*".$datos['apm']."*".$datos['nombres']}}</p></span>
                    </div>
                </div>
                <div class="fila">
                    <div class="dato carrera">
                        <span>Carrera: <p>{{$datos['carr_clv_plt_carr']." ".$datos['carr_nombre_plan']}}</p></span>
                    </div>
                </div>
                <div class="fila">
                    @if ($datos['sistema'] == 'SIAE')
                        <div class="dato nivel">
                            <span>Título a obtener: <p> {{$datos['titulo']}}</p></span>
                        </div>
                    @endif
                </div>
                <div class="fila">
                    @if ($datos['nivel_SIAE'] == 'L')
                        <div class="dato nivel">
                            <span>Nivel: <p>LICENCIATURA</p></span>
                        </div>
                    @endif
                    <div class="dato fecha_nac">
                        <span>Fecha de Nacimineto: <p>{{$datos['fecha_nac']}}</p></span>
                    </div>
                    <div class="dato tipo">
                        @if ($datos['sistema'] == 'DGIRE')
                            <div class="dato expediente">
                                <span>Tipo: <p></p></span>
                            </div>
                        @endif

                    </div>

                </div>
                <div class="fila">
                    <div class="dato sistema">
                        <span>Información proporcionada por: {{$datos['sistema']}}</span>
                    </div>
                </div>
            </div>
            {{-- <div class="recibido">
                <div class="fila">
                    <span>Exp Ncta:</span>
                </div>
                <div class="fila">

                </div>
                <div class="fila">

                </div>
                <div class="fila">

                </div>
            </div> --}}
        </div>
    {{-- @elseif (isset($datos['sistema']) && $datos['sistema'] == 'DGIRE')
        {{dd("DGIRE")}} --}}
    @else
        <div class="info-alumno">
            {{-- {{dd($msj)}} --}}
        </div>

    @endif
@endsection
{{-- @extends('layouts.app')
@section('title', 'CONDOC | Recepción de Expedientes')
@section('estilos')
@section('content')
    <div id="is" class="container recepcion-expedientes">
        <div class="encabezado">
                <h1>Recepción de Expedientes</h1> <span>{{date("d/m/y")}}</span>
        </div>

        <div class="datos">

            <form action="{{ route("postRecepcion") }}" method="POST">
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
    </div>
@endsection --}}



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
