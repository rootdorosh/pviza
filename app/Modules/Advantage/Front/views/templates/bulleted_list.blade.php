<?php
$count = $advantages->count();
$chunkSize = $count / 2;
if ($count % 2 !== 0) {
    $chunkSize = (int) $chunkSize + 1;
}
?>

<div id="advantages" class="advantages js-section">
  <div class="advantages__head">
    <div class="advantages__center center">
      <div class="advantages__container container-fluid">
        <div class="advantages__row row">
          <div class="advantages__col col">
            <h3 class="heading">{{ $category->title }}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="advantages__body">
    <div class="advantages__center center">
      <div class="advantages__container container-fluid">
        <div class="advantages__row row">
          <div class="advantages__col col">
            <div class="advantages__wrap">
              <div class="advantages__list">
                @foreach ($advantages->chunk($chunkSize) as $chunk)
                <div class="advantages__{{ !$loop->index ? 'left' : 'right' }}">
                  @foreach ($chunk as $item)
                  <div class="advantages__item">
                    <div class="advantages__icon"></div>
                    <div class="advantages__title">{{ $item->title }}</div>
                    <div class="advantages__caption">{{ $item->description }}</div>
                  </div>
                  @endforeach
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
