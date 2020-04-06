@foreach ($items as $item)
<div class="col-sm-6 col-lg-3">
    <p class="footer-modern-title">{{ $item['title'] }}</p>
    @if (!empty($item['children']))
    <div class="footer-modern-divider"></div>
    <ul class="list-marked-1">
        @foreach ($item['children'] as $child)
        <li>
            <a href="{{ $child['link'] }}">{{ $child['title'] }}</a>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endforeach
