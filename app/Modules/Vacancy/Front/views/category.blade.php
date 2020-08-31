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
        <?= $widget->view('_search', compact('category'))?>
        <div class="row row-50 flex-lg-row-reverse">
            <div class="col-lg-8 col-xl-9">
                <?= $widget->view('_items', compact('items', 'limit', 'count'))?>

                <div class="text-job-page">
                    {!! $category->description !!}
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="row row-30">
                    <?= $widget->view('_filter', compact('category'))?>
                </div>
            </div>

        </div>
    </div>

</section>
