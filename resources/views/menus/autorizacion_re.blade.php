@extends('menus.numero_cuenta')
@section('esp', $title)
@section('ruta')
    <form class="form-group solicitud" method="POST" action="{{ url( '/autorizacion_re') }}">
@endsection