@extends('menus.numero_cuenta', ['title' => "Solicitud de Revisión de Estudio"])
@section('esp', 'Solicitud de Revisión de Estudios por Alumno')
@section('ruta')
    <form class="form-group solicitud" method="POST" action="{{ url( '/facesc/solicitud_RE' ) }}">

@endsection
