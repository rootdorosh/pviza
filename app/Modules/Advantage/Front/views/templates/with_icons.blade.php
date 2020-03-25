<div id="suitable" class="suitable js-section">
  <div class="suitable__center center">
    <div class="suitable__container container-fluid">
      <div class="suitable__row row">
        <div class="suitable__col col">
          <h3 class="heading">{{ $category->title }}</h3>
          <div class="suitable__list">
            @foreach ($advantages as $item)  
            <div class="suitable__item">
              <div class="suitable__media {{ $item->svg_code }}}"><img src="{{ $item->getThumb('image', 35, 35, 'crop') }}" alt="{{ $item->title }}" class="suitable__media-icon" /></div>
              <div class="suitable__title">{{ $item->title }}</div>
              <div class="suitable__caption">{{ $item->description }}</div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
