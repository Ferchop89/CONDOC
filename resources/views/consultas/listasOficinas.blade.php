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
        <form id="gestionListas" method="POST" action="{{ route("separacion_oficinas") }}">
          {{ method_field('PUT') }}
          {!! csrf_field() !!}
              <div class="form-group">
                 <label for="datepicker1">Fecha de Listado</label>
                 {{ Form::text('datepicker','',array('id'=>'datepicker','readonly', 'class' => '')) }}
                 <button id = "gestionL" type="submit" class="btn btn-primary waves-effect waves-light" name="consultar" value="consultar">Consultar<button/>
              </div>

              @if ($nListas!=0)
                <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{1}}">
                              Corte: {{str_replace('.','/',$corte)}}        Lista: {{$t_solicitudes}}        
                              # Total: {{str_pad(count($data),2,'0',STR_PAD_LEFT)}}
                              </a>
                            </h3>
                          </div>
                        <div id="collapse{{1}}" class="panel-collapse collapse {{$in = (count($data)==1)? "in": ''}}">
                          <div class="panel-body">
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
                              @foreach ($data as $key=>$value)
                                <tr>
                                  <th scope="row">{{($key+1)}}</th>
                                  <td>{{$data[$key]->cuenta}}</td>
                                  <td>{{$data[$key]->nombre}}</td>
                                  <td>{{$data[$key]->procedencia}}</td>
                                  <td>{{explode('-',explode(' ',$data[$key]->created_at)[0])[2].'-'
                                       .explode('-',explode(' ',$data[$key]->created_at)[0])[1].'-'
                                       .explode('-',explode(' ',$data[$key]->created_at)[0])[0].'; '
                                       .explode(' ',$data[$key]->created_at)[1]}}</td>
                                </tr>
                              @endforeach
                              </tbody>
                            </table>
                            <hr>
                            <div class="bAutO">
                              <div style="float: left;"><input type="submit" class="btn btn-primary waves-effect waves-light" name="imprime03" value="Imprimir 03"/></div>
                              <div style="float: right;"><input type="submit" class="btn btn-primary waves-effect waves-light" name="imprime08" value="Imprimir 08"/></div>
                            </div>
                        </div>
                        </div>
                        </div>
                        </div>
                <div>
              @else
                <h4>LA FECHA SELECCIONADA NO TIENE SOLICITUDES. </h4>
              @endif

          </form>
  </div>
@endsection

@section('animaciones')
    <script type="text/JavaScript" src="{{ asset('js/block.js') }}" ></script>
@endsection
