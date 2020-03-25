<div id="additionally" class="additionally js-section">
  <div class="additionally__center center">
    <div class="additionally__container container-fluid">
      <div class="additionally__row row">
        <div class="additionally__col col">
          <h3 class="heading">{{ $category->title }}</h3>
          <div class="tab-primary">
            <ul class="tab-primary__nav nav">
            @foreach ($advantages as $item)    
              <li class="tab-primary__item">
                  <a href="#tab-primary-{{ $item->id }}" data-toggle="tab" class="tab-primary__link {{ !$loop->index ? 'active' : '' }}">{{ $item->title }}</a>
              </li>
            @endforeach  
            </ul>
            <div class="tab-primary__content tab-content">
              @foreach ($advantages as $item)   
              <div id="tab-primary-{{ $item->id }}" class="tab-primary__pane tab-pane fade {{ !$loop->index ? 'show active' : '' }}">
                <h5 class="title-tab">{{ $item->title }}</h5>
                {{ $item->body }}
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
