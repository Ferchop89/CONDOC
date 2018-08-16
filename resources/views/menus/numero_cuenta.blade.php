@extends('layouts.app')
@section('title')
    CONDOC | @yield('esp')
@endsection
@section('location')
    <div>
    	<p id="navegacion">
            <a href="{{ route('home') }}"><i class="fa fa-home" style="font-size:28px"></i></a>
    		<a href="#"><span> >> </span>
    		<span> </span> Licenciatura </a> >>
    		<a href="#"> {{$title}} </a> </p>
    </div>
@endsection
@section('estilos')
    @yield('sub-estilos')
@endsection
@section('content')
    <h2 id="titulo">{{$title}}</h2>
    <div id="is" class="container">
            <div class="panel panel-default">
                {{-- <div class="panel-heading">@yield('esp')</div> --}}
                <div class="panel-body">
                	@yield('ruta')
                		{!! csrf_field() !!}
                        <label for="num_cta"> N° de cuenta: </label>
                    	<input id="num_cta" type="text" name="num_cta" value="{{old('num_cta')}}" maxlength="9" />
                        @if ($errors->any())
                            <div id="error" class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="btn-derecha">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                               	Consultar
                           	</button>
                        </div>
    				</form>

                    {{-- {{dd($errors->all())}} --}}
                    {{-- @if($errors->all()==null)
                        @include('errors.flash-message')
                    @endif --}}
                </div>
			</div>
</div>
    @yield('errores')
<div class="capsule informacion-alumno">
    @yield('identidadAlumno')
</div>
<div class="solicitudes">
    @yield('info-alumno')
</div>
@endsection
