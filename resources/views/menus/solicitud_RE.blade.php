@extends('menus.numero_cuenta')
@section('esp', 'Solicitud de Revisión de Estudios por Alumno')
@section('ruta')

    <form class="form-group solicitud" method="POST" action="{{ url( '/FacEsc/solicitud_RE' ) }}">

@endsection
