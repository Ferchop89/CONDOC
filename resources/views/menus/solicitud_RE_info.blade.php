@extends('layouts.app')
@section('title', 'CONDOC | Solicitud de RE por Alumno')
@section('location')
    >> {{$num_cta}}
@endsection
@section('content')
    <div id="is" class="pta_amplia">

        @if (empty($trayectoria))
            <div class="contenido msj-error">
                <span>{{$msj}}</span>
            </div>
        @else
            {{-- {{dd($trayectoria)}} --}}
            <div class="contenido">
                <div class="info-personal">
                    <img src="{{ asset('images/sin_imagen.png') }}" alt="">
                    <div class="info-personal">
                        <div class="fila">
                            <label for="">Nombre:</label>
                            <label for="">Nº de Cuenta: </label>{{$num_cta}}
                        </div>
                        <div class="fila">
                            <label for="">CURP: </label>
                        </div>
                        <div class="fila">
                            <label for="">Nº de Plantel: </label>{{$trayectoria[0]->plantel_clave}}
                            <label for="">Nombre del Plantel: </label>{{$trayectoria[0]->plantel_nombre}}
                        </div>
                    </div>
                    <div class="info-trayectorias">
                        <table class="table table-bordered">
                            <thead class="thead-dark bg-primary">
                                <th scope="col">Nº</th>
                                <th scope="col">Nº plan de estudios</th>
                                <th scope="col">Plan de Estudios</th>
                                <th scope="col">Avance</th>
                                <th scope="col">Acción</th>
                            </thead>
                            <tbody>


                        @foreach ($trayectoria as $value)
                            <tr>
                                <th>1</th>
                                <td>{{$value->plan_clave}}</td>
                                <td>{{$value->plan_nombre}}</td>
                                <td>{{$value->porcentaje_totales."%"}}</td>
                                <td>
                                    {{-- @if (Si tiene solicitud de estudios)
                                        <a href="{{ route('admin.users.editar_usuarios',[ $user ]) }}">
                                            {{"En proceso"}}
                                        </a>
                                    @else
                                        @if($value->porcentaje_totales >= 75.00)
                                            {{"Solicitar"}}
                                        @else
                                            {{"El alumno nombre con número de cuenta ".$num_cta." . No puede realizar una solicitud de Revisión de estudios, ya que no cumple con el avance necesario."}}
                                        @endif
                                    @endif --}}
                                    <a href="">
                                        {{"boton"}}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="fila">
                    <form class="" action="index.html" method="post">

                        <button type="button" value="Regresar" class="btn btn-primary waves-effect waves-light" onclick="history.back(-1)" />
                            {{"Volver"}}
                        </button>
                    </form>

                </div>
            </div>
        @endif
    </div>
@endsection
