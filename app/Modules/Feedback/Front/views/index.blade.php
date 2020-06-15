<section class="section section-md">
    <div class="container">

        <div class="layout-bordered">
            {!! (new App\Modules\ContentBlock\Front\Widget('index', [
                'block_id' => conf('cb_page_contact_header'),
                'template' => 'empty',
            ]))->run() !!}
        </div>
        <div class="row">
            <div class="col-12">
                <h4>{{ t('feedback.form.title') }}</h4>
                <p>{{ t('feedback.form.sub_title') }}</p>
                <!-- RD Mailform-->
                <form class="rd-mailform form-lg"
                      id="form-feedback"
                      action="{{ r('front.feedback.send') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row row-30">
                        <div class="col-lg-4">
                            <div class="form-wrap">
                                <label class="form-label" for="name">{{ t('feedback.form.fields.name') }}</label>
                                 <input class="form-input" id="name" type="text" name="name">
                                <span class="message-error"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-wrap">
                                <label class="form-label" for="email">{{ t('feedback.form.fields.email') }}</label>
                                <input class="form-input" id="email" type="email" name="email">
                                <span class="message-error"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-wrap">
                                <label class="form-label" for="contact">{{ t('feedback.form.fields.phone') }}</label>
                                <input class="form-input" id="contact" type="text" name="phone">
                                <span class="message-error"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-wrap">
                                <label class="form-label" for="message">{{ t('feedback.form.fields.message') }}</label>
                                <textarea class="form-input" id="message" name="message"></textarea>
                                <span class="message-error"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="button button-primary" type="submit">{{ t('feedback.form.btn.submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row row-50">
            <div class="col-md-10 col-lg-8 col-xl-6">
                {!! (new App\Modules\ContentBlock\Front\Widget('index', [
                    'block_id' => conf('cb_page_contact_footer'),
                    'template' => 'empty',
                ]))->run() !!}
            </div>
        </div>


    </div>
</section>
