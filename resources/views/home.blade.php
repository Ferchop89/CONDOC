@extends('layouts.app')
@section('estilos')
    <link href="{{ asset('css/MenuHome.css') }}" rel="stylesheet">
@endsection
@section('content')
<div id="is" class="container">
    {{-- <div class="row"> --}}
        {{-- <div class="col-md-8 col-md-offset-2"> --}}
            <div class="panel panel-default">
                <div class="tab panel-heading">
                    @noadmin
                        @if (count($items_role)>0)
                            @foreach ($menus as $key => $item)
                                @if ($item['parent'] != 0)
                                    @break
                                @endif
                                @include('partials.menu-item2', ['item' => $item])
                            @endforeach
                        @endif
                    @endnoadmin
                </div>
                <div class="padre">
                    <div class="hijo">
                        <span>Bienvenid@ al sistema CONDOC</span>
                    </div>
                </div>
                @noadmin
                    @if (count($items_role)>0)
                        @foreach ($menus as $key => $item)
                            @if ($item['parent'] != 0)
                                @break
                            @endif
                            @include('partials.menu-item3', ['item' => $item])
                        @endforeach
                    @endif
                @endnoadmin
            </div>
        {{-- </div> --}}
    {{-- </div> --}}
</div>
@endsection
@section('animaciones')
    <script type="text/javascript" src="{{ asset('js/MenuHome.js') }}"></script>
@endsection
