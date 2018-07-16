@extends('layouts.app')

@section('title',$title)

@section('content')
<div class="container">
    <h1 class="pb-1">
        Vista de expediente no encontrado en AGUNAM
    </h1><br><br>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <h5>Por favor corrige los siguientes debajo</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li> {{ $error}}  </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url("agunam/{$expediente->id}/salvar") }}">
            {{ method_field('PUT') }}
            {!! csrf_field() !!}
            <label><font color="SaddleBrown">Datos de la solicitud</font></label>
            <table class="table table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">cuenta</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Procedencia</th>
                        <th scope="col">Alta Web</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $expediente->cuenta }}</td>
                    <td>{{ $expediente->nombre }}</td>
                    <td>{{ $expediente->procedencia }}</td>
                    <td>{{ Carbon\Carbon::parse($expediente->created_at)->format('d-m-Y; h:m') }}</td>
                  </tr>
                </tbody>
            </table>
            <label><font color="SaddleBrown">Datos del Corte-Listado al que pertenece la solicitud</font></label>
            <table class="table table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Corte</th>
                        <th scope="col">Listado</th>
                        <th scope="col">Fecha envio</th>
                        <th scope="col">Fecha recepcion</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $agunam->listado_corte }}</td>
                    <td>{{ $agunam->listado_id }}</td>
                    <td>{{ ($agunam->Solicitado_at!=null)?Carbon\Carbon::parse($agunam->Solicitado_at)->format('d-m-Y; h:m'): '----' }}</td>
                    <td bgcolor="BurlyWood"><strong>{{ ($agunam->Recibido_at!=null)?Carbon\Carbon::parse($agunam->Recibido_at)->format('d-m-Y; h:m'): '----' }}</strong></td>
                  </tr>
                </tbody>
            </table>
            <label><font color="SaddleBrown">Datos Actualización</font></label>
            <table class="table table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Encontrado</th>
                        <th scope="col">Fecha no recibido </th>
                        <th scope="col">Fecha Encontrado</th>
                        <th scope="col">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> {{ Form::checkbox('encontrado', null, $expediente->encontrado) }} </td>
                    <td bgcolor="BurlyWood"><strong>{{ ($agunam->Recibido_at!=null)?Carbon\Carbon::parse($agunam->Recibido_at)->format('d-m-Y; h:m'): '----' }}</strong></td>
                    <td>{{ ($expediente->Encontrado_at!=null)?Carbon\Carbon::parse($expediente->Encontrado_at)->format('d-m-Y'): '----' }}</td>
                    <td>{{$expediente->descripcion}}</td>
                  </tr>
                </tbody>
            </table>
            {{-- <button type="submit" class="btn btn-primary" {{ (!$edita)? 'disabled' : '' }}>Actualizar</button> --}}
            <a href="{{ route('agunam/expedientes') }}" class="btn btn-primary waves-effect waves-light">Regresar a la lista de expedientes no encontrados</a>
        </form>
    </div>
</div>
@endsection
@section('animaciones')
    {{-- Para el uso del datepicker --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('js/datepicker.js')}}"></script>
@endsection
