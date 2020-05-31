@if (!empty($items))
    @foreach ($items as $item)
        <div class="col-sm-6 col-lg-4">
            <article class="post-classic"><a class="post-classic-media" href="{{ d_l('/' . $item->alias) }}">
                <img class="post-classic-image" src="{{ $item->getThumb('image', 369, 253, 'resize')  }}" alt="{{ $item->title  }}"/></a>
                <h4 class="post-classic-title"><a href="{{ d_l('/' . $item->alias) }}">{{ $item->title  }}</a></h4>
                <time class="post-classic-time">{{ date('d.m.Y', $item->created_at)  }}</time>
                <div class="post-classic-text">
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->description), 200)  }}</p>
                </div>
            </article>
        </div>
    @endforeach
@endif
