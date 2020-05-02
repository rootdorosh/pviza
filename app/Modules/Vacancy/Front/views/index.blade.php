<section class="section section-md">
    <div class="container">
        <?= $widget->view('_search')?>
        <div class="row row-50 flex-lg-row-reverse">
            <div class="col-lg-4 col-xl-3">
                <div class="row row-30">
                    <?= $widget->view('_filter')?>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9">
                <?= $widget->view('_items', compact('items', 'limit', 'count'))?>
            </div>
        </div>
    </div>	

</section>
