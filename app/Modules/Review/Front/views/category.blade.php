<section class="section breadcrumbs-custom breadcrumbs-custom-overlay-4">
    <div class="breadcrumbs-custom-main bg-image bg-gray-700" style="background-image: url({!! $category->getThumb('image') !!});">
        <div class="container">
            <h3 class="breadcrumbs-custom-title">
                {!! FrontPage::getH1() !!}
            </h3>
        </div>
    </div>
</section>

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
