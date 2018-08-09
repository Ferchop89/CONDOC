@extends('layouts.app')
@section('title', 'CONDOC | '.$title)
@section('location')
    <div>
    	<p id="navegacion">
            <a href="{{ route('home') }}"><i class="fa fa-home" style="font-size:28px"></i></a>
            <span> >> </span>
        	<a> Licenciatura </a>
            <span> >> </span>
    		<a href="#"> {{$title}} </a> </p>
    </div>
@endsection

@section('content')
    <h2 id="titulo">{{$title}}</h2>
    @include('errors/flash-message')
    <div class="capsule solicitud_re">
        <div class="contenido">
            <div class="info">
                <div class="info-personal">
                    <img src="{{ asset('images/sin_imagen.png') }}" alt="">
                    <div class="info-personal-header">
                            <div class="fila">
                                <label for="">Nombre: </label> {!! $identidad->nombres."*".$identidad->apellido1."*".$identidad->apellido2 !!}
                            </div>
                            <div class="fila">
                                <label for="">Nº de Cuenta: </label> {!! $identidad->cuenta !!}
                            </div>
                            <div class="fila">
                                <label for="">CURP: </label>@if($identidad->curp) {!! $identidad->curp !!} @endif
                            </div>
                        </div>
                    </div>
                    @if ($trayectoria!=null)
                        {{-- <div class="info-platel">
                            <div class="fila">

                            </div>
                        </div> --}}
                        <div class="info-trayectorias">
                            <form action="{{ route('solicita_RE',[ $identidad->cuenta ]) }}" method="POST">
                                {{ csrf_field() }}
                                <table class="table table-bordered">
                                    <thead class="thead-dark bg-primary">
                                        <th scope="col">Nº</th>
                                        <th scope="col">Nº de Plantel</th>
                                        <th scope="col">Nombre del Plantel</th>
                                        <th scope="col">Nº plan de estudios</th>
                                        <th scope="col">Plan de Estudios</th>
                                        <th scope="col">Avance</th>
                                        <th scope="col">Acción</th>
                                    </thead>
                                    <tbody>
                                        {{-- {{dd($trayectoria)}} --}}
                                        @foreach ($trayectoria as $key => $value)
                                            <tr>
                                                <th>{{$key+1}}</th>
                                                <td>{{$value->plantel_clave}}</td>
                                                <td>{{$value->plantel_nombre}}</td>
                                                <td>{{$value->plan_clave}}</td>
                                                <td>{{$value->plan_nombre}}</td>
                                                <td>{{$value->porcentaje_totales."%"}}</td>
                                                <td>
                                                    {{-- {{dd()}} --}}
                                                    @if (empty($solicitudes) && $msj=='')
                                                        <input type="hidden" name="num_cta" value="{{$identidad->cuenta}}">
                                                        <input type="hidden" name="nombre" value="{{$identidad->nombres."*".$identidad->apellido1."*".$identidad->apellido2}}">
                                                        <input type="hidden" name="avance" value="{{$value->porcentaje_totales}}">
                                                        <input type="hidden" name="plantel_id" value="{{$value->plantel_clave}}">
                                                        <input type="hidden" name="carrera_id" value="{{$value->carrera_clave}}">
                                                        <input type="hidden" name="plan_id" value="{{$value->plan_clave}}">
                                                        @if ($tipo==1)
                                                            <button type="submit" class="btn btn-default">
                                                                {!!"Solicitar"!!}
                                                            </button>
                                                        @else
                                                            <a href="">
                                                                {!!"Generar Citatorio"!!}
                                                            </a>
                                                        @endif

                                                    @else
                                                        @foreach ($solicitudes as $key => $solicitud)
                                                            @if($solicitud->plantel_id == $value->plantel_clave && $solicitud->carrera_id == $value->carrera_clave && $solicitud->plan_id == $value->plan_clave && $solicitud->pasoACorte == 0)
                                                                {{-- {{dd($solicitud)}} --}}
                                                                <a href="{{ asset(route('cancela_RE', [$solicitud->id])) }}">
                                                                    {!!"Cancelar"!!}
                                                                </a>
                                                            @elseif($solicitud->plantel_id == $value->plantel_clave && $solicitud->carrera_id == $value->carrera_clave && $solicitud->plan_id == $value->plan_clave && $solicitud->pasoACorte == 1)
                                                                <a href="">
                                                                    {!!"En proceso"!!}
                                                                </a>
                                                            @else
                                                                <a href="">
                                                                    {!!"Autorizada"!!}
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    {{-- @if ($solictud != null)
                                                        @if ($solicitud)

                                                        @endif
                                                        <button type="button" value="Regresar" class="btn btn-primary waves-effect waves-light" onclick="history.back(-1)" />
                                                            {{"Volver"}}
                                                        </button>
                                                    @endif --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    @endif
                    {{-- @if (Session::has('message'))
                       <div class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif --}}

                </div>
                <div class="fila">
                    <form class="" action="index.html" method="post">

                        <button type="button" value="Regresar" class="btn btn-primary waves-effect waves-light" onclick="history.back(-1)" />
                            {{"Volver"}}
                        </button>
                    </form>

                </div>
            </div>
        {{-- @endif --}}
    </div>
@endsection
