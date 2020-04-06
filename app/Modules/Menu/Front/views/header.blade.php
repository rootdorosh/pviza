<ul class="rd-navbar-nav">
    @foreach ($items as $item)
    <li class="rd-nav-item">
        <a class="rd-nav-link" href="{{ $item['link'] }}">{{ $item['title'] }}</a>
        @if (!empty($item['children']))
        <ul class="rd-menu rd-navbar-dropdown">
            @foreach ($item['children'] as $child)
            <li class="rd-dropdown-item">
                <a class="rd-dropdown-link" href="{{ $child['link'] }}">{{ $child['title'] }}</a>
            </li>
            @endforeach
        </ul>
        @endif
    </li>
    @endforeach    
</ul>        
