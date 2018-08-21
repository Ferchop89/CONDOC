@extends('menus.numero_cuenta')
    @section('esp', $title)
    @section('sub-estilos')
        <link href="{{ asset('css/recepcion.css') }}" rel="stylesheet">
    @endsection
    @section('ruta')
        <form class="form-group solicitud" method="POST" action="{{ route("postRecepcion") }}">
    @endsection
    @section('errores')
        @include('errors/flash-message')
    @endsection
    @if (isset($datos))
        @section('identidadAlumno')
            @include('menus.identidadAlumno')
        @endsection
        @section('info-alumno')
        @endsection
    @endif

        {{-- @if(isset($datos['sistema']))
            @include('errors/flash-message')
            <div class="info-alumno">
                <div class="control">
                    <div>
                        <form class="form-group solicitud" method="POST" action="{{ route("saveRecepcion") }}">
                            {!! csrf_field() !!}
                            <input name="num_cta" type="hidden" value="{{$datos['num_cta']}}">
                            <input type="hidden" name="nombreC" value="{{$datos['app']."*".$datos['apm']."*".$datos['nombres']}}">
                            <input type="submit" name="btnRecepcion" value="Recibir">
                        </form>
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
                            <span>Fecha de Nacimiento: <p>{{$datos['fecha_nac']}}</p></span>
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
            </div>
        @else
            <div class="info-alumno">
            </div>
        @endif --}}
