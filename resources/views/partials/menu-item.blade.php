{{-- @if ($item['submenu'] != [])
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $item['name'] }} <span class="caret"></span></a>
        <ul class="dropdown-menu">
            @foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])
                    <li><a  href="{{ url($submenu['ruta']) }}">
                            {{ $submenu['name']}}
                        </a>
                    </li>
                @else
                    @include('partials.menu-item', [ 'item' => $submenu ])
                @endif
            @endforeach
        </ul>
    </li>
@endif --}}
@if ($item['submenu'] != [])
    @if ($item['is_structure'] && $item['parent'] != 0)
        <li class="divider"></li>
        <li class="dropdown-header">
            {{ $item['name'] }}
            {{-- <ul class="dropdown-menu"> --}}
                @foreach ($item['submenu'] as $submenu)
                    @if ($submenu['submenu'] == [])
                        <li><a  href="{{ url($submenu['ruta']) }}">
                                {{ $submenu['name']}}
                            </a>
                        </li>
                    @else
                        @include('partials.menu-item', [ 'item' => $submenu ])
                    @endif
                @endforeach
            {{-- </ul> --}}
        </li>
    @else
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                {{ $item['name'] }}
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                @foreach ($item['submenu'] as $submenu)
                    @if ($submenu['submenu'] == [])
                        <li><a  href="{{ url($submenu['ruta']) }}">
                                {{ $submenu['name']}}
                            </a>
                        </li>
                    @else
                        @include('partials.menu-item', [ 'item' => $submenu ])
                    @endif
                @endforeach
            </ul>
        </li>
    @endif

@endif
{{-- <div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Tutorials
    <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li class="dropdown-header">Dropdown header 1</li>
      <li><a href="#">HTML</a></li>
      <li><a href="#">CSS</a></li>
      <li><a href="#">JavaScript</a></li>
      <li class="divider"></li>
      <li class="dropdown-header">Dropdown header 2</li>
      <li><a href="#">About Us</a></li>
    </ul>
  </div> --}}
