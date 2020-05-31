<section class="section breadcrumbs-custom breadcrumbs-custom-overlay-1">
    <div class="breadcrumbs-custom-main bg-image bg-gray-700" style="background-image: url({!! $blog->getThumb('image_header') !!});">
        <div class="container">
            <h3 class="breadcrumbs-custom-title">{!! FrontPage::getH1() !!}</h3>
        </div>
    </div>
</section>

<section class="section section-md">
    <div class="container">
        <div class="blog-layout">
            <div class="blog-layout-main">
                <article class="post-creative"><img class="post-creative-image" src="{{ $blog->getThumb('image', 768, 475, 'resize')  }}" alt="{{ $blog->title  }}"/>
                    <div class="post-creative-meta">
                        <div class="post-creative-meta-inner">
                            <div>
                                <ul class="post-creative-meta-list">
                                    <li> <span class="icon mdi mdi-clock"> </span>
                                        <time>{{ date('d.m.Y', $blog->created_at)  }}</time>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <h5>{{ $blog->title  }}</h5>
                    {!! $blog->description !!}

                    <div class="post-creative-footer">
                        <div class="post-creative-footer-inner">
                            <p>{{ t('share-this-post')  }}</p>
                            <div>
                                <ul class="list-inline list-inline-xs">
                                    <li><a class="icon icon-xxs icon-filled icon-filled-brand icon-circle fa fa-facebook" href="#"></a></li>
                                    <li><a class="icon icon-xxs icon-filled icon-filled-brand icon-circle fa fa-google-plus" href="#"></a></li>
                                    <li><a class="icon icon-xxs icon-filled icon-filled-brand icon-circle fa fa-twitter" href="#"></a></li>
                                    <li><a class="icon icon-xxs icon-filled icon-filled-brand icon-circle fa fa-pinterest-p" href="#"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </article>

                @if (!empty($related))
                <div class="section-sm section-first">
                    <p class="blog-layout-title text-center">{{ t('related-posts')  }}</p>
                    <div class="row row-30">
                        @foreach($related as $item)
                        <div class="col-sm-6">
                            <article class="post-classic">
                                <a class="post-classic-media" href="{{ d_l('/'. $item->alias) }}">
                                    <img class="post-classic-image" src="{{ $item->getThumb('image', 369, 253, 'resize') }}" alt="{{ $item->title }}"/>
                                </a>
                                <h4 class="post-classic-title"><a href="{{ d_l('/'. $item->alias) }}">{{ $item->title }}</a></h4>
                                <time class="post-classic-time">{{ date('d.m.Y', $item->created_at) }}</time>
                                <div class="post-classic-text">
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->title), 200) }}</p>
                                </div>
                            </article>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <div class="blog-layout-aside">
                <div class="blog-layout-aside-item">
                    <!-- RD Search-->
                    <form class="rd-form rd-search rd-search-classic form-lg form-filled" action="{{ d_l('/viza-work-blog') }}" method="GET">
                        <div class="form-wrap">
                            <input class="form-input" id="rd-search-form-input" type="text" name="q" autocomplete="off">
                            <label class="form-label" for="rd-search-form-input">{{ t('search-the-blog') }}</label>
                        </div>
                        <button class="rd-search-submit" type="submit"></button>
                    </form>
                </div>
                <div class="blog-layout-aside-item">
                    <p class="blog-layout-title">{{ t('categories')  }}</p>
                    <ul class="list-categories">
                    @foreach($categories as $item)
                        <li {!! $blog->category_id == $item->id ? 'class="active"' : '' !!}>
                            <a href="{{ d_l('/category/' . $item->alias)  }}"> <span>{{ $item->title }}</span><span> {{ $item->c }}</span></a>
                        </li>
                    @endforeach
                    </ul>
                </div>
                <div class="blog-layout-aside-item">
                    <p class="blog-layout-title">{{ t('latest-posts')  }}</p>
                    <div class="post-light-group">
                        @foreach($latests as $item)
                        <a class="post-light" href="{{ d_l('/'. $item->alias) }}">
                            <div class="post-light-media"><img class="post-light-image" src="{{ $item->getThumb('image', 106, 104, 'resize') }}" alt="{{ $item->title }}"/>
                            </div>
                            <div class="post-light-main">
                                <p class="post-light-title">{{ $item->title }}</p>
                                <time class="post-light-time" datetime="">{{ date('d.m.Y', $item->created_at) }}</time>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

