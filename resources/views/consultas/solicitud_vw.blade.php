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
		<div class="search cell center">
				<i class="fa fa-search fa-3x " aria-hidden="true"></i>
				<input type='text' name="cuenta" id='search' placeholder='Número de Cuenta'>
		</div>
		{!! Form::open(['class'=>'form','method'=>'GET','id'=>'solicitudes_V', 'route'=>'cortesV']) !!}
			{{-- {{ method_field('PUT') }}
			{!! csrf_field() !!} --}}
			{!! Form::date('fecha_v', $fecha_Sel) !!};
			{!! Form::select('plantel_id',$escuelas,$plantel,['class' => 'form-control', 'placeholder' => 'Todos los Planteles']) 	!!}

			{!!$sol_Html!!}

		{!! Form::close() !!}

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="{{asset('css/select2.css')}}" rel="stylesheet" />
    <script src="{{asset('js/select2.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          $('select').select2();
          $('#solicitudes_V select').change(function(){
            $('#solicitudes_V').submit();
          });
					$('#solicitudes_V input').change(function(){
						$('#solicitudes_V').submit();
					});
        });
    </script>
@endsection
