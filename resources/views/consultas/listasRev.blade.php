@extends('layouts.app')
@section('title', 'CONDOC | '.$title)
@section('location')
    <div>
    	<p id="navegacion">
            <a href="{{ route('home') }}"><i class="fa fa-home" style="font-size:28px"></i></a>
    		<a href="#"><span></span>
    		<span> </span> Licenciatura </a> >>
    		<a href="{{ url('/cortes') }}"> {{$title}} </a> </p>
    </div>
@endsection
@section('estilos')
    <link href="{{ asset('css/listados.css') }}" rel="stylesheet">
@endsection
@section('content')
  <div class="capsule">
    <h2 id="titulo">{{$title}}</h2>
        <form id="gestionListas" method="GET" action="{{ route("listas") }}">
              {{-- {{ method_field('PUT') }} --}}
              {{-- {!! csrf_field() !!} --}}
              {{-- <p>Fecha: <input type="text" id="datepicker" name="datepicker"></p> --}}
              <div class="form-group">
                 <label for="datepicker1">Fecha de Listado</label>
                 {{-- <p>Date: <div type="text" id="datepicker"></div></p> --}}
                 {{ Form::text('datepicker','',array('id'=>'datepicker','readonly', 'class' => '')) }}
                 <button id = "gestionL" type="submit" class="btn btn-primary">Consultar</button>
              </div>

          @if ($nListas!=0)
            {{-- {!!$listas!!} --}}
            <div class="panel-group" id="accordion">
                @for ($i=0; $i < count($data); $i++)
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i+1}}">
                          Corte: {{str_replace('.','/',$corte)}}        Lista: {{$i+1}}        
                          # Solicitudes: {{str_pad(count($data[$i]),2,'0',STR_PAD_LEFT)}}        {{$procede[$i]}}
                          </a>
                        </h3>
                      </div>
                    <div id="collapse{{$i+1}}" class="panel-collapse collapse {{$in = (count($data)==1)? "in": ''}}">
                      <div class="panel-body">
                          <button name="btnLista" type="submit" value="{{$i+1}}" class="btn btn-danger btn-xs">PDF</button>
                          <button name="btnVale" type="submit" value="{{$i+1}}" class="btn btn-success btn-xs">Vales</button>
                          <button name="btnEtiqueta" type="submit" value="{{$i+1}}" class="btn btn-info btn-xs">Etiquetas</button>
                    <div class="table-responsive">
                        <table class="table table-striped">
                        <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col"><strong>No. Cta</strong></th>
                              <th scope="col"><strong>Nombre</strong></th>
                              <th scope="col"><strong>Escuela o Facultad</strong></th>
                              <th scope="col"><strong>Fecha; Hora</strong></th>
                          </tr>
                        </thead>
                          <tbody>
                          @for ($x=0; $x < count($data[$i]); $x++)
                            <tr>
                              <th scope="row">{{($x+1)}}</th>
                              <td>{{$data[$i][$x]->cuenta}}</td>
                              <td>{{$data[$i][$x]->nombre}}</td>
                              <td>{{$data[$i][$x]->procedencia}}</td>
                              <td>{{explode('-',explode(' ',$data[$i][$x]->created_at)[0])[2].'-'
                                   .explode('-',explode(' ',$data[$i][$x]->created_at)[0])[1].'-'
                                   .explode('-',explode(' ',$data[$i][$x]->created_at)[0])[0].'; '
                                   .explode(' ',$data[$i][$x]->created_at)[1]}}</td>
                            </tr>
                          @endfor
                          </tbody>
                        </table>
                    </div>
                    </div>
                    </div>
                    </div>
                  @endfor
            <div>
          </form>
          @else
            <h4>LA FECHA SELECCIONADA NO TIENE LISTAS</h4>
          @endif
  </div>
@endsection

@section('animaciones')
    <script type="text/JavaScript" src="{{ asset('js/block.js') }}" ></script>
@endsection
