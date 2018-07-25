@extends('layouts.app')

@section('title','CONDOC | '.$title)
@section('location')
    <div>
    	<p id="navegacion">
            <a href="{{ route('home') }}"><i class="fa fa-home" style="font-size:28px"></i></a>
    		<span> >> </span>
    		<a> Licenciatura </a>
            <span> >> </span>
            <a href="{{ route('AGUNAM') }}">AGUNAM</a>
            <span> >> </span>
    		<a href="#"> {{$title}} </a> </p>
    </div>
@endsection
@section('content')
<div class="capsule agunam-e">
    <h2 id="titulo">{{$title}}</h2>
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
            <div class="origen">
                <div class="form-group corte">
                    <label for="corte">Corte</label>
                    <strong>
                        <input type="text" class="form-control" name="corte" id="corte" value="{{ old('corte',$agunam[0]['listado_corte']) }}" readonly/>
                    </strong>
                </div>
                <div class="form-group lista">
                    <label for="listado">Listado</label>
                    <strong>
                        <input type="text" class="form-control" name="listado" id="listado" value="{{ old('listado',$agunam[0]['listado_id']) }}" readonly/>
                    </strong>
                </div>
            </div>
            <div class="fechas">
                <div class="form-group envio">
                    <label for="solicitar">Fecha de Envio a AGUNAM</label>
                    <input type="date" class="form-control" name="solicitar" id="solicitar" value="{{ SUBSTR($agunam[0]['Solicitado_at'],0,10) }}" />
                </div>
                <div class="form-group recepcion">
                    <label for="recibir">Fecha Recepción en CERCONDOC</label>
                    {{-- <input type="date" class="form-control" name="recibir" id="recibir" value "{{ old('recibir',$agunam[0]['Recibido_at']) }}" /> --}}
                    <input type="date" class="form-control" name="recibir" id="recibir" value="{{ SUBSTR($agunam[0]['Recibido_at'],0,10) }}" />
                </div>
            </div>

            <div class="form-group btns">
                <button type="submit" class="btn btn-primary">Actualizar Listado</button>
                <a href="{{ route('AGUNAM',['mes'=>$mesCorte]) }}" class="btn btn-primary waves-effect waves-light">Regresar a la Listas AGUNAM</a>
            </div>
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
