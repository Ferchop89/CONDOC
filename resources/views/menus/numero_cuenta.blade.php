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
@yield('ruta')
    <h2 id="titulo">{{$title}}</h2>
    <div id="is" class="container">
            <div class="panel panel-default">
                {{-- <div class="panel-heading">@yield('esp')</div> --}}

                {!! csrf_field() !!}
                    <div class="panel-body">
                        <div class="solicitud">
                            <label for="num_cta"> N° de cuenta: </label>
                            @if(isset($num_cta))
                               <input id="num_cta" type="text" name="num_cta" value="{{$num_cta}}" maxlength="9" />
                            @else
                                <input id="num_cta" type="text" name="num_cta" maxlength="9" />
                            @endif
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
                                <input type="submit" class="btn btn-primary waves-effect waves-light" name="consultar" value="Consultar"/>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    @yield('info-alumno')
</form>
@endsection
