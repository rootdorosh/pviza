@if (!empty($items))
<ul>
    @foreach ($items as $item)
    <li><a href="{{ $item['link'] }}">{{ $item['name'] }}</a></li>
    @endforeach
</ul>
@endif