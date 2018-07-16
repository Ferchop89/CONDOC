@extends('layouts.app')

@section('title',$title)

@section('content')
<div class="container">
    <h1 class="pb-1">
        Editar Listado de Solicitudes
    </h1>
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

        <form method="POST" action = "{{route('agunamUpdateOk')}}">
            {{ method_field('PUT') }}
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="corte">Corte:</label>
                <input type="text" class="form-control" name="corte" id="corte" value="{{ old('corte',$agunam[0]['listado_corte']) }}" readonly/>
            </div>
            <div class="form-group">
                <label for="listado">Listado</label>
                <input type="text" class="form-control" name="listado" id="listado" value="{{ old('listado',$agunam[0]['listado_id']) }}" readonly/>
            </div>
            <div class="form-group">
                <label for="solicitar">Fecha de Envio a AGUNAM</label>
                <input type="date" class="form-control" name="solicitar" id="solicitar" value="{{ SUBSTR($agunam[0]['Solicitado_at'],0,10) }}" />
            </div>
            <div class="form-group">
                <label for="recibir">Fecha Recepción en CERCONDOC</label>
                {{-- <input type="date" class="form-control" name="recibir" id="recibir" value "{{ old('recibir',$agunam[0]['Recibido_at']) }}" /> --}}
                <input type="date" class="form-control" name="recibir" id="recibir" value="{{ SUBSTR($agunam[0]['Recibido_at'],0,10) }}" />
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Listado</button>
            <a href="{{ route('gestion_agUnam',['mes'=>$mesCorte]) }}" class="btn btn-primary waves-effect waves-light">Regresar a la Listas AGUNAM</a>
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
