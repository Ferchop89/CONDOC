@if ($item['submenu'] != [])
    @foreach ($item as $key => $value)
        @if($key=='name')
            <button class="tablinks" onclick="openCity(event, '{{$item['name']}}')">
                <div class="info">
                    {{$item['name']}}
                </div>
        @endif
    @endforeach
            </button>
@endif
