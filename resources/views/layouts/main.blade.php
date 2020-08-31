<?php

?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="{{ l() }}">
    <head>
        <title>{{ FrontPage::getTitle() }}</title>
        <meta name="description" content="{{ FrontPage::getDescription() }}" />
        <meta name="viewport" content="width=device-width height=device-height initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="icon" href="/markup/images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:400%7CPoppins:300,400,500,600">
        <link rel="stylesheet" href="/markup/css/bootstrap.css">
        <link rel="stylesheet" href="/markup/css/fonts.css">
        <link rel="stylesheet" href="/markup/css/style.css" id="main-styles-link">

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-79773012-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-79773012-1');
        </script>

    </head>
    <body>
        <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
        <div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="/markup/images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
        <div class="preloader">
            <div class="preloader-body">
                <div class="preloader-item">
                    <svg width="40" height="40" viewbox="0 0 40 40">
                    <polygon class="rect" points="0 0 0 40 40 40 40 0"></polygon>
                    </svg>
                </div>
            </div>
        </div>
        <div class="page">
            <!-- Page Header-->
            <header class="section page-header">
                <!-- RD Navbar-->
                <div class="rd-navbar-wrap rd-navbar-classic-light">
                    <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
                        <div class="rd-navbar-main-outer">
                            <div class="rd-navbar-main">

                                <!-- RD Navbar Panel-->
                                <div class="rd-navbar-panel">
                                    <!-- RD Navbar Toggle-->
                                    <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                                    <!-- RD Navbar Brand-->

                                    <div class="rd-navbar-brand"><a class="brand" href="{{ d_l('/') }}"><img class="brand-logo-dark" src="/markup/images/logo-default-176x33.png" alt="" srcset="/markup/images/logo-default-176x33.png 2x"/><img class="brand-logo-light" src="/markup/images/logo-inverse-176x33.png" alt="" srcset="/markup/images/logo-inverse-352x67.png 2x"/></a>
                                    </div>
                                </div>
                                <div class="rd-navbar-main-element">
                                    <div class="rd-navbar-nav-wrap">
                                        {!! (new App\Modules\Menu\Front\Widget('index', [
                                            'menu_id' => conf('menu_header_id'),
                                            'template' => 'header',
                                        ]))->run() !!}
                                    </div>
                                </div>
                                <div class="rd-navbar-aside">
                                    <div class="rd-navbar-aside-item">
                                        <?php $langLinksMap = FrontPage::getLangLinksMap();?>
                                        @foreach (FrontPage::getDomain()->site_langs as $lang)
                                        <li style="display:inline;">
                                            <a href="{{ isset($langLinksMap[$lang]) ? $langLinksMap[$lang] : switchUrl(request()->path(), $lang) }}">
                                                <img src="/markup/images/{{ $lang }}.png" alt="{{ $lang }}" style="padding-left:5px;float:right;max-width:35px;max-height:25px;">
                                            </a>
                                        </li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>

            {!! $content !!}

            <!-- Page Footer-->
            <footer class="section footer-modern context-dark">
                <div class="footer-modern-main">
                    <div class="container">
                        <div class="row row-50 justify-content-lg-between">
                            <div class="col-lg-5">
                            {!! (new App\Modules\ContentBlock\Front\Widget('index', [
                                'block_id' => conf('cb_contact_footer'),
                                'template' => 'empty',
                            ]))->run() !!}
                            </div>

                            {!! (new App\Modules\Menu\Front\Widget('index', [
                                'menu_id' => conf('menu_footer_id'),
                                'template' => 'footer',
                            ]))->run() !!}

                        </div>
                    </div>
                </div>
                <div class="footer-modern-aside">
                    <div class="container">
                        <div class="footer-modern-aside-inner">
                            <div class="footer-modern-aside-item">
                                <p class="rights"><span><?= t('work-in-poland')?></span><span>&nbsp;&copy;&nbsp;</span><span class="copyright-year"></span><span>&nbsp;</span><a href="<?= d_l('privacy-policy')?>"><?= t('privacy-policy')?></a></p>
                            </div>
                            <div class="footer-modern-aside-item">
                                <ul class="list-inline list-inline-sm">
                                    @foreach (['facebook', 'twitter', 'instagram'] as $social)
                                      @if (!empty(conf('social_' . $social)))
                                      <li><a target="_blank" class="icon icon-xs fa fa-{{ $social }}" href="{{ conf('social_' . $social) }}"></a></li>
                                      @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <div class="snackbars" id="form-output-global"></div>
        <script src="/markup/js/core.min.js"></script>
        <script src="/markup/js/script.js"></script>
        <script src="/markup/js/dev.js"></script>
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5f0eacb888f281a5"></script>

    </body>
</html>
