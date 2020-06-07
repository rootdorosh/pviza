@if (!empty($items))
    @foreach ($items as $item)
        <div class="col-md-6 col-lg-4">
            <blockquote class="quote-classic">
                <svg class="quote-classic-mark" version="1.1" x="0px" y="0px" viewbox="0 0 36 28" width="38" height="28">
                    <path d="M13,0l-2.4,13.3H15V28H0V13.1L4,0H13z M34,0l-2.4,13.3H36V28H20.9V13.1L25,0H34z"></path>
                </svg>
                <div class="quote-classic-text">
                    <p>{!! str_replace("\n", "<br/>", $item->comment) !!}</p>
                </div>
                <div class="quote-classic-meta"><img class="quote-classic-avatar" src="images/user-1-73x73.jpg" alt=""/>
                    <div class="quote-classic-info">
                        <cite class="quote-classic-cite heading-5">{{ $item->name }}</cite>
                    </div>
                </div>
            </blockquote>
        </div>
    @endforeach
@endif
