<!DOCTYPE html><!-- Language сodes http://www.w3schools.com/tags/ref_language_codes.asp -->
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="description" content="{{ FrontPage::getDescription() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="format-detection" content="telephone=no" /><!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/markup/img/favicon/favicon.ico" />
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/markup/img/favicon/favicon.ico?v=1.0" />
    <link rel="shortcut icon" type="image/png" sizes="24x24" href="/markup/img/favicon/favicon-24x24.png" />
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="/markup/img/favicon/favicon-32x32.png" />
    <link rel="shortcut icon" type="image/png" sizes="64x64" href="/markup/img/favicon/favicon-64x64.png" />
    <link rel="shortcut icon" type="image/png" sizes="96x96" href="/markup/img/favicon/favicon-96x96.png" />
    <meta name="msapplication-TileColor" content="#fff" />
    <meta name="msapplication-TileImage" content="/markup/img/favicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" href="/markup/img/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="57x57" href="/markup/img/favicon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/markup/img/favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/markup/img/favicon/apple-touch-icon-114x114.png" />
    <title>{{ FrontPage::getTitle() }}</title>
    <link href="/markup/css/main.css?{{ config('app.version') }}" rel="stylesheet" />
    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
  </head>
  <body>
    <div class="support">You are using an outdated browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</div>
    <div class="up">Up</div>
    <div class="wrap">
      <!-- header -->
      <header class="header">
        <div class="header__center center">
          <div class="header__container container-fluid">
            <div class="header__row row">
              <div class="header__col col">
                <div class="header__wrap">
                  <div class="header__left">
                    <div class="header__logo">
                      <div class="logo"><a href="{{ d_l('/') }}" class="logo-link"><img src="/markup/img/logo.svg" alt="Zoral Cloud" class="logo-img" /></a></div>
                    </div>
                  </div>
                  <div class="header__right">
                    <div class="header__main">
                      <div class="header__btn-menu">
                        <div class="btn btn-menu"><i></i></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="header__menu">
          <div class="header__inner">
            <div class="header__center center">
              <div class="header__container container-fluid">
                <div class="header__row row">
                  <div class="header__col col">
                    <div class="header__panel">
                      <div class="header__main-menu">
                          {!! (new App\Modules\Menu\Front\Widget('index', [
                              'menu_id' => Setting::get('menu_header_id'),
                              'template' => 'header',
                          ]))->run() !!}
                      </div>
                      <div class="header__info">
                          {!! (new App\Modules\ContentBlock\Front\Widget('index', [
                              'block_id' => Setting::get('cb_contact_header'),
                              'template' => 'empty',
                          ]))->run() !!}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header><!-- /.header -->
      <!-- middle -->
      <div class="middle">
          {!! $content !!}
      </div><!-- /.middle -->
      <!-- footer -->
      <footer class="footer">
        <div class="footer__center center">
          <div class="footer__container container-fluid">
            <div class="footer__row row">
              <div class="footer__col col">
                <div class="footer__wrap">
                  <div class="footer__cell">
                    <div class="footer__nav">
                        {!! (new App\Modules\Menu\Front\Widget('index', [
                            'menu_id' => Setting::get('menu_footer_id'),
                            'template' => 'footer',
                        ]))->run() !!}
                    </div>
                    <div class="footer__social">
                      <nav class="menu-social">
                        <ul class="menu-social__list">
                        @foreach (['facebook', 'youtube'] as $social)
                            @if (!empty(Setting::get('social_' . $social)))
                            <li class="menu-social__item">
                                <a href="{{ Setting::get('social_' . $social) }}" target="_blank" class="menu-social__link">
                                    <svg class="menu-social__icon icon-{{ $social }}">
                                        <use xlink:href="/markup/img/sprite.svg#{{ $social }}"></use>
                                    </svg>
                                </a>
                            </li>
                            @endif
                        @endforeach
                        </ul>
                      </nav>
                    </div>
                  </div>
                  <div class="footer__cell">
                    <div class="footer__contact">
                        {!! (new App\Modules\ContentBlock\Front\Widget('index', [
                            'block_id' => Setting::get('cb_contact_footer'),
                            'template' => 'empty',
                        ]))->run() !!}
                    </div>
                  </div>
                </div>
                <div class="footer__developer">
                  <div class="developer"><a href="https://sunbee.studio/" target="_blank" class="developer__link"><img src="/markup/img/sunbee.svg" alt="SunBee" class="developer__img" /></a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer><!-- /.footer -->
    </div>
    <script src="/markup/js/main.js?{{ config('app.version') }}"></script>
    <script src="/js/app.js?{{ config('app.version') }}"></script>
  </body>
</html>
