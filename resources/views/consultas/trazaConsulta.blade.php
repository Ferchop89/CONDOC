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
    <img src='/images/sin_imagen.png' alt='Alumno'>

    <table class='table table-bordered table-hover'>
      <thead>
      <tr>
        <th>Cuenta</th>
        <th>Nombre</th>
        <th>Plantel</th>
        <th>Carrera</th>
        <th>Plan</th>
        <th>Avance</th>
        <th></th>
      </tr>
      </thead>
      <tr>
        <td><strong>{{$solicitud[0]['cuenta']}}</strong></td>
        <td><strong>{{$solicitud[0]['nombre']}}</strong></td>
        <td><strong>{{$solicitud[0]['plantel_id']}}</strong></td>
        <td><strong>{{$solicitud[0]['carrera_id']}}</strong></td>
        <td><strong>{{$solicitud[0]['plan_id']}}</strong></td>
        <td><strong>{{$solicitud[0]['avance']}}</strong></td>
      </tr>
    </table>
  </br>
  {!!$trazaCompleta!!}
  </br>
  <button type="button" class="btn btn-success" onclick="goBack()">Regresar</button>
@endsection
@section('animaciones')
    <script type="text/JavaScript" src="{{ asset('js/block.js') }}" ></script>
    <script>
      function goBack() {window.history.back();}
    </script>
@endsection
