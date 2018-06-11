@extends('layouts.app')
@section('title') 
    CONDOC | @yield('esp')
@endsection
@section('content')
<div id="is" class="container">
    {{-- <div class="row"> --}}
        {{-- <div class="col-md-8 col-md-offset-2"> --}}
            <div class="panel panel-default">
                <div class="panel-heading">@yield('esp')</div>
                <div class="panel-body">

                        @if ($errors->any())
                            <div id="error" class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                	@yield('ruta')
                		{!! csrf_field() !!}

                        <label for="num_cuenta"> N° de cuenta: </label>
                    	<input id="num_cuenta" type="text" name="num_cuenta" value="" maxlength="9" />

                        <div class="btn-derecha">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                               	Consultar
                           	</button>
                        </div>

    				</form>
                </div>
			</div>
        {{-- </div> --}}
    {{-- </div> --}}
</div>
@endsection
