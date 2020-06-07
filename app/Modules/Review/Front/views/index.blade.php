<section class="section section-md bg-gray-100">
    <div class="container">
        <div class="row row-50">
            <?= $widget->view('_items', compact('items', 'limit', 'count'))?>
        </div>
        <nav class="pagination-outer text-center" aria-label="Page navigation">
            {!! (new \App\Services\Pager(['limit' => $limit, 'count' => $count]))->run() !!}
        </nav>

        <div class="row">
            <div class="col-12">
                <h4>{{ t('review.form.title') }}</h4>

                    <form class="rd-mailform form-lg"
                          id="form-review"
                          action="{{ r('front.review.send') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row row-30">
                        <div class="col-lg-4">
                            <div class="form-wrap">
                                <label class="form-label" for="review-name">{{ t('review.form.fields.name') }}</label>
                                <input class="form-input" id="review-name" type="text" name="name">
                                <span class="message-error"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-wrap">
                                <label class="form-label" for="review-email">{{ t('review.form.fields.email') }}</label>
                                <input class="form-input" id="review-email" type="text" name="email">
                                <span class="message-error"></span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-wrap">
                                <label class="form-label" for="review-comment">{{ t('review.form.fields.comment') }}</label>
                                <textarea class="form-input" id="review-comment" name="comment"></textarea>
                                <span class="message-error"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="button button-primary" type="submit">{{ t('review.form.btn.submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
