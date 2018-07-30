@if ($item['submenu'] != [])
    <div id="{{$item['name']}}" class="tabcontent">
        @foreach ($item['submenu'] as $submenu)
            <ul>
            	<a href="{{($submenu['ruta'] == null) ? '#' : $submenu['ruta']}}" class="{{($submenu['ruta'] == null) ? 'cabecera' : ''}}">
                    {{$submenu['name']}}
                </a>
                @if(isset($submenu['submenu'][0]))
                    @for ($i=0; $i < count($submenu['submenu']); $i++)
                        <li>
                            <a href="{{$submenu['submenu'][$i]['ruta']}}">
                                {!!$submenu['submenu'][$i]['name']!!}
                            </a>
                        </li>
                    @endfor
                @endif
            </ul>
        @endforeach
    </div>
@endif
