<?php 

?>

<!DOCTYPE html>
<html class="wide wow-animation" lang="{{ l() }}">
    <head>
        <title>{{ FrontPage::getTitle() }}</title>
        <meta name="description" content="{{ FrontPage::getDescription() }}" />
        <meta name="viewport" content="width=device-width height=device-height initial-scale=1.0">
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow" />
        <link rel="icon" href="/markup/images//favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:400%7CPoppins:300,400,500,600">
        <link rel="stylesheet" href="/markup/css/bootstrap.css">
        <link rel="stylesheet" href="/markup/css/fonts.css">
        <link rel="stylesheet" href="/markup/css/style.css" id="main-styles-link">
    </head>
    <body>
        <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
        <div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="/markup/images//ie8-panel/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
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

                                    <div class="rd-navbar-brand"><a class="brand" href="_main.html"><img class="brand-logo-dark" src="/markup/images//logo-default-176x33.png" alt="" srcset="/markup/images//logo-default-352x67.png 2x"/><img class="brand-logo-light" src="/markup/images//logo-inverse-176x33.png" alt="" srcset="/markup/images//logo-inverse-352x67.png 2x"/></a>
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
                                        @foreach (FrontPage::getDomain()->site_langs as $lang)
                                        <li style="display:inline;">  
                                            <a href="{{ switchUrl(request()->path(), $lang) }}">
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
                                'menu_id' => conf('menu_footer_id'),
                                'template' => 'footer',
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
                                <p class="rights"><span>Робота в Польщі</span><span>&nbsp;&copy;&nbsp;</span><span class="copyright-year"></span><span>&nbsp;</span><a href="privacy-policy.html">Privacy Policy</a></p>
                            </div>
                            <div class="footer-modern-aside-item">
                                <ul class="list-inline list-inline-sm">
                                    <li><a class="icon icon-xs fa fa-facebook" href="#"></a></li>
                                    <li><a class="icon icon-xs fa fa-twitter" href="#"></a></li>
                                    <li><a class="icon icon-xs fa fa-google-plus" href="#"></a></li>
                                    <li><a class="icon icon-xs fa fa-pinterest-p" href="#"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- PANEL-->
        <div class="layout-panel-wrap" id="layout-panel-wrap">
            <div class="layout-panel">
                <button class="layout-panel-toggle" data-custom-toggle="#layout-panel-wrap"><span></span></button>
                <div class="layout-panel-content"> 
                    <p class="layout-panel-title">Choose Color Scheme</p>
                    <div class="theme-switcher-group">
                        <button class="theme-switcher-group-item" data-theme-name="default"><span></span>Default</button>
                        <button class="theme-switcher-group-item" data-theme-name="style-1"><span></span>Style 1</button>
                        <button class="theme-switcher-group-item" data-theme-name="style-2"><span></span>Style 2</button>
                        <button class="theme-switcher-group-item" data-theme-name="style-3"><span></span>Style 3</button>
                        <button class="theme-switcher-group-item" data-theme-name="style-4"><span></span>Style 4</button>
                        <button class="theme-switcher-group-item" data-theme-name="style-5"><span></span>Style 5</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="snackbars" id="form-output-global"></div>
        <script src="/markup/js/core.min.js"></script>
        <script src="/markup/js/script.js"></script>
    </body>
</html>