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
@section('estilos')
    <link href="{{ asset('css/listados.css') }}" rel="stylesheet">
@endsection
@section('content')
    <h2 id="titulo">{{$title}}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>Corrige las inconsistencias siguientes:</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error}}  </li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['class'=>'form','method'=>'GET','id'=>'formTraza', 'route'=>'traza']) !!}
			{{-- {{ method_field('PUT') }}
			{!! csrf_field() !!} --}}
      {!! Form::label('l_traza', 'Número de Cuenta')!!};
			{!! Form::text('cuenta') !!};
      {!! Form::submit('Consulta',['class'=>'btn btn-primary btn-lg']) !!};
		{!! Form::close() !!}
	  {{-- {!!$html!!} --}}

  @if ($data!='')
    <img src='/images/sin_imagen.png' alt='Alumno'>
    <h3>Cuenta:  {{$data[0]['cuenta']}}</h3>
    <h4>Nombre:  {{$data[0]['nombre']}}</h4> </br>
    <table class='table table-bordered table-hover'>
      <thead>
      <tr>
      <th>Plantel</th>
      <th>Carrera</th>
      <th>Plan</th>
      <th>Avance</th>
      <th>Plantel Captura</th>
      <th>Fecha Captura</th>
      <th></th>
      </tr>
      </thead>
      @foreach ($data as $solicitud)
        <tr>
          <td><strong>{{$solicitud['plantel_id']}}</strong></td>
          <td><strong>{{$solicitud['carrera_id']}}</strong></td>
          <td><strong>{{$solicitud['plan_id']}}</strong></td>
          <td><strong>{{$solicitud['avance']}}</strong></td>
          <td><strong>{{App\Models\User::find($solicitud['user_id'])->procede()->first()->procedencia}}</strong></td>
          <td><strong>{{$solicitud['created_at']}}</strong></td>
          <td>
             <a href="{{ route('trazabilidad',[ $solicitud['cuenta'], $solicitud['carrera_id'], $solicitud['plan_id'] ]) }}"><i class="fa fa-eye" style="font-size:34px;color:#c5911f"></i></a>
          </td>

        </tr>
      @endforeach
    </table></br>
  @endif

@endsection
@section('animaciones')
    <script type="text/JavaScript" src="{{ asset('js/block.js') }}" ></script>
@endsection
