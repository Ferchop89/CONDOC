@extends('layouts.app')
@section('title', 'CONDOC | '.$title)
@section('location')
    <div>
    	<p id="navegacion">
            <a href="{{ route('home') }}"><i class="fa fa-home" style="font-size:28px"></i></a>
            <span> >> </span>
        	<a> Reportes</a>
            <span> >> </span>
    		<a href="#"> {{$title}} </a> </p>
    </div>
@endsection
@section('estilos')
    <link href="{{ asset('css/listados.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="capsule graficas">
        <h2 id="titulo">{{$title}}</h2>
        {!! Form::open(['class'=>'form','method'=>'GET','id'=>'Sol_Cit', 'route'=>'graficas']) !!}
          {!! Form::select('anio_id',$anio,$aSel) !!}
          {!! Form::select('mes_id',$mes,$mSel) !!}
          {!! Form::select('origen_id',$origen,$oSel)!!}
        {!! Form::close() !!}

        <div style="float: left; width: 50%">
            {!! $chart1->render() !!}
        </div>
        <div style="float: left; width: 50%">
            {!! $chart2->render() !!}
        </div>

        <div>
        <table class="table table-hover">
          <tr>
            <td>Dia</td>
              @foreach ($data as $key => $value)
               <td>{{$key}}</td>
              @endforeach
          </tr>
          <tr>
            <td>solicitud</td>
              @foreach ($data as $key => $value)
               <td>{{$value[0]}}</td>
              @endforeach
          </tr>
          <tr>
            <td>citatorios</td>
              @foreach ($data as $key => $value)
               <td>{{$value[1]}}</td>
              @endforeach
          </tr>
        </table>

        </div>

        <div style="float: left; width: 48%">
            {!! $chart2->render() !!}
        </div>
        <div style="float: left; width: 48%">
            {!! $chart1->render() !!}
        </div>
    </div>
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
          $('#Sol_Cit select').change(function(){
            $('#Sol_Cit').submit();
          });
        });
    </script>
@endsection
