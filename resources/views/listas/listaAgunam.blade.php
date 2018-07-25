@extends('layouts.app')
@section('title', 'CONDOC | '.$title)
@section('location')
    <div>
    	<p id="navegacion">
            <a href="{{ route('home') }}"><i class="fa fa-home" style="font-size:28px"></i></a>
    		<span> >> </span>
    		<a> Licenciatura </a>
            <span> >> </span>
    		<a href="#"> {{$title}} </a> </p>
    </div>
@endsection
@section('content')
<div class="capsule agunam">

      {{-- <h2>Listas de Solicitud AGUNAM</h2> --}}

    <h2 id="titulo">{{$title}}</h2>
    <form id="corte" action="{{ route('AGUNAM',['mes'=>$mesCorte]) }} method="POST"">
      <label for="mes">Mes de Consulta</label>
      <input id="mes" type="month" name="mes" value={{$mesCorte}}>
      <button  id="btnMes" name="btnMes" type="submit" class="btn btn-success">Consulta</button>
    </form>
    @if(count($listas)>0)
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Corte</th>
                    <th scope="col">Listado</th>
                    <th scope="col">Promoción</th>
                    <th scope="col">Fecha Solicitud</th>
                    <th scope="col">Fecha Recibido</th>
                    <th scope="col">Operación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listas as $lista)
                    <tr>
                        <td>{{ str_replace('/','-',$lista['listado_corte']) }}</td>
                        <td>{{ $lista['listado_id'] }}</td>
                        <td>{{ $lista['procedencia'] }}</td>
                        <td>{{ ($lista['Solicitado_at']==null)? '---':
                          explode('-',substr($lista['Solicitado_at'],0,10))[2].'-'.
                          explode('-',substr($lista['Solicitado_at'],0,10))[1].'-'.
                          explode('-',substr($lista['Solicitado_at'],0,10))[0]
                         }}</td>
                        <td>{{ ($lista['Recibido_at']==null)? '---':
                          explode('-',substr($lista['Recibido_at'],0,10))[2].'-'.
                          explode('-',substr($lista['Recibido_at'],0,10))[1].'-'.
                          explode('-',substr($lista['Recibido_at'],0,10))[0]
                        }}</td>
                        <td>
                           <a href="{{ route('agunamUpdate',[ $lista['listado_corte'], $lista['listado_id'] ]) }}"><i class="fa fa-edit" style="font-size:34px;color:#c5911f"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </form>
    @else
        <p>
            No hay listas.
        </p>
    @endif
</div>
{{-- <div class="paginador">
    {{ $users->links()}}
</div> --}}
@endsection
