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
                                                <p class="object-inline object-inline_sm"><span class="icon icon-1 text-primary mdi mdi-map-marker"></span><span class="joblocation">Пшеворськ</span></p>
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


                <div class="block offset-top-2">
                    <h4>{{ t('related-vacancies-title') }}</h4>
                    <table class="table-job-listing table-responsive">
                        <tr>
                            <td class="table-job-listing-main">
                                <!-- Company Minimal-->
                                <article class="company-minimal">
                                    <figure class="company-minimal-figure"><img class="company-minimal-image" src="images/company-2-53x46.png" alt=""/>
                                    </figure>
                                    <div class="company-minimal-main">
                                        <h5 class="company-minimal-name"><a href="job-details.html">Marketing Director</a></h5>
                                        <p>UpBook, Saint-Etienne, France</p>
                                    </div>
                                </article>
                            </td>
                            <td class="table-job-listing-badge"><span class="badge badge-secondary">Part Time</span></td>
                        </tr>
                        <tr>
                            <td class="table-job-listing-main">
                                <!-- Company Minimal-->
                                <article class="company-minimal">
                                    <figure class="company-minimal-figure"><img class="company-minimal-image" src="images/company-3-42x42.png" alt=""/>
                                    </figure>
                                    <div class="company-minimal-main">
                                        <h5 class="company-minimal-name"><a href="job-details.html">Front End Developer</a></h5>
                                        <p>MediaLab, Derry, United Kingdom</p>
                                    </div>
                                </article>
                            </td>
                            <td class="table-job-listing-badge"><span class="badge badge-tertiary">Freelance</span></td>
                        </tr>
                        <tr>
                            <td class="table-job-listing-main">
                                <!-- Company Minimal-->
                                <article class="company-minimal">
                                    <figure class="company-minimal-figure"><img class="company-minimal-image" src="images/company-4-40x43.png" alt=""/>
                                    </figure>
                                    <div class="company-minimal-main">
                                        <h5 class="company-minimal-name"><a href="job-details.html">Website Designer</a></h5>
                                        <p>Creator, Los Angeles, CA, USA</p>
                                    </div>
                                </article>
                            </td>
                            <td class="table-job-listing-badge"><span class="badge">Full Time</span></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row row-30 row-lg-50">
                    <div class="col-md-6 col-lg-12">
                        <!-- RD Mailform-->
                        <form class="rd-mailform form-corporate form-spacing-small form-corporate_sm" data-form-output="form-output-global" data-form-type="contact" method="post" action="bat/rd-mailform.php">
                            <h4>Подати заяву на роботу</h4>
                            <div class="form-wrap">
                                <label class="form-label" for="contact-name">ІМЯ, ПРІЗВИЩЕ (ОБОВЯЗКОВО)</label>
                                <input class="form-input" id="contact-name" type="text" name="name" data-constraints="@Required">
                            </div>
                            <div class="form-wrap">
                                <label class="form-label" for="contact-email">E-mail не обовязково</label>
                                <input class="form-input" id="contact-email" type="email" name="email" data-constraints="@Required @Email">
                            </div>
                            <div class="form-wrap">
                                <label class="form-label" for="contact-phone">ТЕЛЕФОН (ОБОВЯЗКОВО)</label>
                                <input class="form-input" id="contact-phone" type="text" name="phone" data-constraints="@PhoneNumber">
                            </div>
                            <div class="form-wrap">
                                <label class="form-label" for="contact-message">ПОВІДОМЛЕННЯ</label>
                                <textarea class="form-input" id="contact-message" name="message" data-constraints="@Required"></textarea>
                            </div>
                            <div class="form-wrap">
                                <button class="button button-block button-anorak button-primary" type="submit">Відправити заявку</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
