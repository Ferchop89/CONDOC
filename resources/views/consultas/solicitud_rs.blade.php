@extends('layouts.app')
@section('title', 'CONDOC | '.$title)

@section('location')
<div>
	<p id="navegacion">
		{{-- <i class="fa fa-home"></i> --}}
		<a href="{{ route('home') }}"><i class="fa fa-home" style="font-size:28px"></i></a>
		<a href=""><span></span>
		<span> </span> Licenciatura </a> >>
		<a href="{{ url('/cortes') }}"> {{$title}} </a> </p>
</div>
@endsection
@section('estilos')
    <link href="{{ asset('css/listados.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="capsule cortes">

@if ($solW_cta>0)
    <h2 id="titulo">{{$title}}</h2>

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

    <form id="corte" method="POST" action="{{ url("creaListas") }}">
        {{ method_field('PUT') }}
        {!! csrf_field() !!}

        <div class="form-group">
            <div class="listados cell center">
                <label for="lista">Listados a generar</label>
                <input type='text' name="lista" value="{{old('lista')}}" id='lista'  maxlength="2" size="2">
				<button type="submit" class="btn btn-primary">Generar Listados</button>
            </div>
            <div class="facesc cell center">
                <label for="facultad">Escuelas/Facultades</label>
                {!! $esc_Html !!}
            </div>
            <div class="search cell center">
                <i class="fa fa-search fa-3x " aria-hidden="true"></i>
                <input type='text' name="cuenta" id='search' placeholder='Número de Cuenta'>
            </div>
        </div>
		<div class="form-group">
          <div>
            <label for="pruebas">Regeneración de registros para pruebas.</label>
            <input type="checkbox" name="pruebas">
          </div>
        </div>

        {{-- <a href="{{ route('cortes') }}" class="btn btn-primary">filtrar</a> --}}

        {!!$sol_Html!!}
    </form>
@else
  <div class="form-group">
    <br><br>
    <h4 class="text-center">REVISIONES PENDIENTES DE LISTADO</h4>
    <br><br>
    <h3 class="text-center">No existen revisiones pendientes</h3>
    <br><br>
  </div>
</div>
@endif
@endsection

@section('animaciones')
    <script type="text/JavaScript" src="{{ asset('js/block.js') }}" ></script>
@endsection
