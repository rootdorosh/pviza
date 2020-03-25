<nav class="menu-foot">
  <ul class="menu-foot__list">
    @foreach ($items as $item)  
    <li class="menu-foot__item">
        <a href="{{ $item['link'] }}" class="menu-foot__link {{ $item['active'] ? 'active' : '' }}">{{ $item['title'] }}</a>
    </li>
    @endforeach 
  </ul>
</nav>       