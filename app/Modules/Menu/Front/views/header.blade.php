 <nav class="header__menu-main menu-main">
  <ul class="menu-main__list">
    @foreach ($items as $item)  
    <li class="menu-main__item">
        <a href="{{ $item['link'] }}" class="menu-main__link {{ $item['active'] ? 'active' : '' }}">{{ $item['title'] }}</a>
    </li>
    @endforeach 
  </ul>
</nav>    
    