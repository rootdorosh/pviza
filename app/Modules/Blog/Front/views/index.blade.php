<section class="section section-md">
    <div class="container">
        <div class="row row-50 row-xl-70">
            <?= $widget->view('_items', compact('items', 'limit', 'count'))?>
        </div>
        <nav class="pagination-outer text-center" aria-label="Page navigation">
            {!! (new \App\Services\Pager(['limit' => $limit, 'count' => $count]))->run() !!}
        </nav>
    </div>
</section>
