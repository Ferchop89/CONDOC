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
        <h2 id="titulo">{{$title}}: Prueba</h2>
        <div class="filtros">
            {!! Form::open(['class'=>'form','method'=>'GET','id'=>'Sol_Cit', 'route'=>'graficas']) !!}
                <div class="fil anio">
                    <label class="inline" for="filtro">Año:</label>
                    {!! Form::select('anio_id',$anio,$aSel, ['class' => 'anio']) !!}
                </div>
                <div class="fil mes">
                    <label class="inline" for="filtro">Mes:</label>
                    {!! Form::select('mes_id',$mes,$mSel) !!}
                </div>
                <div class="fil plantel">
                    <label class="inline" for="filtro">Plantel:</label>
                    {!! Form::select('origen_id',$origen,$oSel)!!}
                </div>
            {!! Form::close() !!}
        </div>
        <div class="graficos">
            <div class="graf-left">
                {!! $chart1->render() !!}
            </div>
            <div class="graf-right">
                {!! $chart2->render() !!}
            </div>
        </div>


        <div class="resumen">
        <table class="table table-hover">
          <tr>
            <td class="row_table">Día</td>
              @foreach ($data as $key => $value)
               <td class="tab_num"><strong>{{$key}}</strong></td>
              @endforeach
          </tr>
          <tr>
            <td class="row_table">Solicitud</td>
              @foreach ($data as $key => $value)
               <td class="tab_num">{{$value[0]}}</td>
              @endforeach
          </tr>
          <tr>
            <td class="row_table">Citatorios</td>
              @foreach ($data as $key => $value)
               <td class="tab_num">{{$value[1]}}</td>
              @endforeach
          </tr>
        </table>

        </div>

        {{-- <div style="float: left; width: 48%">
            {!! $chart2->render() !!}
        </div>
        <div style="float: left; width: 48%">
            {!! $chart1->render() !!}
        </div> --}}
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
    {{-- <script src="{{asset('js/graf_height.js')}}"></script> --}}
    <script type="text/javascript">
        $(document).ready(function(){
          $('select').select2();
          $('#Sol_Cit select').change(function(){
            $('#Sol_Cit').submit();
          });
        });
    </script>
@endsection
