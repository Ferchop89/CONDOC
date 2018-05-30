@if ($item['submenu'] != [])
    <div id="{{$item['name']}}" class="tabcontent">
        @foreach ($item['submenu'] as $submenu)
            <li>
                <a href="#">
                    {{$submenu['name']}}
                </a>
            </li>
        @endforeach
    </div>
@endif
