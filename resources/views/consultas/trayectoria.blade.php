@extends('layouts.app')
@section('content')
    <h1>Trayectoria</h1>
    <form action="{{ url('/WS/trayectorias') }}" method="POST">
        {{ method_field('PUT') }}
        {!! csrf_field() !!}
        <label for="trayectoria">Ingresa número de cuenta</label>
        <input type="text" id="trayectoria" name="trayectoria">
        <button type="submit" name="button">Consultar</button>
    </form>
@endsection
