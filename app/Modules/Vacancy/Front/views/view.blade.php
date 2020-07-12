<section class="section breadcrumbs-custom breadcrumbs-custom-overlay-1">
    <div class="breadcrumbs-custom-main bg-image bg-gray-700" style="background-image: url({!! $vacancy->getThumb('image') !!});">
        <div class="container">
            <h3 class="breadcrumbs-custom-title">{!! FrontPage::getH1() !!}</h3>
        </div>
    </div>
</section>
<section class="section section-md">
    <div class="container">
        <div class="row row-50">
            <div class="col-lg-8">

                <div class="layout-details">
                    <article class="company-light company-light_1">
                        <div class="company-light-main">
                            <h5 class="company-light-title">{!! $vacancy->title !!}</h5>
                            <div class="company-light-info">
                                <div class="row row-15 row-bordered">
                                    <div class="col-sm-6">
                                        <ul class="list list-xs">
                                            <li>
                                                <p class="object-inline object-inline_sm"><span class="icon icon-1 text-primary mdi mdi-map-marker"></span><span class="joblocation">{!! $vacancy->locations !!}</span></p>
                                            </li>
                                            <li>
                                                <p class="object-inline object-inline_sm"><span class="icon icon-default text-primary mdi mdi-clock"></span><span>{!! $vacancy->date_posted !!}</span></p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <ul class="list list-xs">
                                            <li>
                                                <p class="object-inline object-inline_sm"><span class="icon icon-sm text-primary mdi mdi-cash"></span><span>{{ t('salary') }} {!! $vacancy->salary !!}</span></p>
                                            </li>
                                            <li>
                                                <p class="object-inline object-inline_sm"><span class="icon icon-1 text-primary mdi mdi-web"></span><span>{!! $vacancy->contract_type !!}</span></p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <p class="text-style-1">
                    {!! str_replace("\n", "<br/>", $vacancy->description) !!}
                </p>
            </div>
            <div class="col-lg-4">
                <div class="row row-30 row-lg-50">
                    <div class="col-md-6 col-lg-12">
                        <form class="rd-mailform form-corporate form-spacing-small form-corporate_sm"
                              id="form-resume"
                              action="{{ r('front.resume.send') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="vacancy_id" value="{{ $vacancy->vacancy_id }}">
                            <h4>{{ t('resume.form.title') }}</h4>
                            <div class="form-wrap">
                                <label class="form-label" for="resume-name">{{ t('resume.form.fields.name') }}</label>
                                <input class="form-input" id="resume-name" type="text" name="name">
                                <span class="message-error"></span>
                            </div>
                            <div class="form-wrap">
                                <label class="form-label" for="resume-email">{{ t('resume.form.fields.email') }}</label>
                                <input class="form-input" id="resume-email" name="email">
                                <span class="message-error"></span>
                            </div>
                            <div class="form-wrap">
                                <label class="form-label" for="resume-phone">{{ t('resume.form.fields.phone') }}</label>
                                <input class="form-input" id="resume-phone" type="text" name="phone">
                                <span class="message-error"></span>
                            </div>
                            <div class="form-wrap">
                                <label class="form-label" for="resume-message">{{ t('resume.form.fields.message') }}</label>
                                <textarea class="form-input" id="resume-message" name="message"></textarea>
                                <span class="message-error"></span>
                            </div>
                            <div class="form-wrap">
                                <label class="form-label" for="resume-file"></label>
                                <input class="form-input" id="resume-file" type="file" name="file">
                                <span class="message-error"></span>
                            </div>
                            <div class="form-wrap">
                                <button class="button button-block button-anorak button-primary js-submit" type="submit">{{ t('resume.form.btn.submit') }}</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
