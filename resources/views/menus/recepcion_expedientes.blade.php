@extends('layouts.app')
@section('title', 'CONDOC | Recepción de Expedientes')
@section('estilos')
    <link href="{{ asset('css/recepcion.css') }}" rel="stylesheet">
@section('content')
    <div id="is" class="container">
        <div class="encabezado">
                <h1>Recepción de Expedientes</h1> <span>{{date("d/m/y")}}</span>
        </div>

        <div class="datos">
            <form action="">
                <div class="form-datos">
                    <div class="num_cta dato-in">
                        <label for="num_cta">Número de Cuenta</label>
                        <input type="text" name="num_cta" value="" max="9">
                    </div>
                    <div class="nombre dato-in">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" value="" max="100">
                    </div>
                    <div class="nombre dato-in">
                        <input type="submit" name="" value="Buscar">
                    </div>
                </div>
            </form>
        </div>
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
    </div>

@endsection
