
<!DOCTYPE html><!-- Language сodes http://www.w3schools.com/tags/ref_language_codes.asp -->
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="{{ FrontPage::getDescription() }}" />
  <meta name="author" content="Lilia Lisakovska" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  <meta name="format-detection" content="telephone=no" />
  <link rel="shortcut icon" type="image/x-icon" href="/markup/img/favicon/favicon.ico" />
  <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/markup/img/favicon/favicon.ico?v=1.0" />
  <link rel="shortcut icon" type="image/png" sizes="32x32" href="/markup/img/favicon/favicon-32x32.png" />
  <link rel="shortcut icon" type="image/png" sizes="64x64" href="/markup/img/favicon/favicon-64x64.png" />
  <link rel="shortcut icon" type="image/png" sizes="96x96" href="/markup/img/favicon/favicon-96x96.png" />
  <meta name="msapplication-TileColor" content="#fff" />
  <meta name="msapplication-TileImage" content="/markup/img/favicon/favicon-114x114.png" />
  <link rel="apple-touch-icon" href="/markup/img/favicon/favicon.ico" />
  <link rel="apple-touch-icon" sizes="72x72" href="/markup/img/favicon/favicon-72x72.png" />
  <link rel="apple-touch-icon" sizes="114x114" href="/markup/img/favicon/favicon-114x114.png" />
  <title>{{ FrontPage::getTitle() }}</title>
  <link rel="stylesheet" href="/markup/css/main.css?{{ config('app.version') }}">
  <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body class="{{ FrontPage::getBodyClass() }}">
  <div class="support">You are using an outdated browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</div>
  
  @if (FrontPage::getBodyClass() === 'body-start')
  <div class="welcome">
    <div class="welcome__list"></div>
    <div class="welcome__wrap">
      <div class="welcome__logo">
        <svg class="welcome__logo-icon">
          <use xlink:href="/markup/img/sprite.svg#logo"></use>
        </svg>
      </div>
      <div class="welcome__set">
        <svg class="welcome__decor">
          <use xlink:href="/markup/img/sprite.svg#hexagon"></use>
        </svg>
        <svg class="welcome__decor">
          <use xlink:href="/markup/img/sprite.svg#hexagon"></use>
        </svg>
        <svg class="welcome__decor">
          <use xlink:href="/markup/img/sprite.svg#hexagon"></use>
        </svg>
        <svg class="welcome__decor">
          <use xlink:href="/markup/img/sprite.svg#hexagon"></use>
        </svg>
        <svg class="welcome__decor">
          <use xlink:href="/markup/img/sprite.svg#hexagon"></use>
        </svg>
        <svg class="welcome__decor">
          <use xlink:href="/markup/img/sprite.svg#hexagon"></use>
        </svg>
      </div>
    </div>
  </div>
  @endif
  
  <div class="wrap wrap-start">
    <!-- header -->
    <header class="header">
      <div class="header__main">
        <div class="header__center center">
          <div class="header__wrap">
            <div class="header__logo">
              <div class="logo">
                <a href="{{ d_l('/') }}" class="logo__link">
                  <svg class="logo__img">
                    <use xlink:href="/markup/img/sprite.svg#logo"></use>
                  </svg>
                </a>
              </div>
            </div>
            <div class="header__main">
              <div class="header__panel">
                  
                {!! (new App\Modules\Menu\Front\Widget('index', [
                    'menu_id' => conf('menu_header_id'),
                    'template' => 'header',
                ]))->run() !!}
                  
                <div class="header__btn js-menu-btn-open">
                  <svg class="header__btn-icon">
                    <use xlink:href="/markup/img/sprite.svg#honeycomb"></use>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="header__menu-basic">
        <div class="menu-basic">
          <div class="menu-basic__center center">
            <div class="menu-basic__wrap">
              <div class="menu-basic__close js-menu-btn-close">
                <svg class="menu-basic__close-icon">
                  <use xlink:href="/markup/img/sprite.svg#close"></use>
                </svg>
              </div>
              <div class="menu-basic__main">
                <div class="menu-basic__panel">
                  <nav class="menu-basic__nav">
                    <ul class="menu-basic__nav-list">
                      <li class="menu-basic__nav-item">
                        <a href="#" class="menu-basic__nav-link">Услуги</a>
                      </li>
                      <li class="menu-basic__nav-item">
                        <a href="#" class="menu-basic__nav-link">Портфолио</a>
                      </li>
                      <li class="menu-basic__nav-item">
                        <a href="#" class="menu-basic__nav-link">Технологии</a>
                      </li>
                      <li class="menu-basic__nav-item">
                        <a href="#" class="menu-basic__nav-link">Контакты</a>
                      </li>
                    </ul>
                  </nav>
                  <div class="menu-basic__info">
                    <div class="menu-basic__info-title">Просчет стоимости</div>
                    <div class="menu-basic__info-phone">
                      <a href="tel:+{{ phoneToInt(conf('contact_phone')) }}" class="menu-basic__info-link">{{ conf('contact_phone') }}</a>
                    </div>
                    <div class="menu-basic__info-email">
                      <a href="maito:{{ conf('contact_email') }}" class="menu-basic__info-link">{{ conf('contact_email') }}</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header><!-- /.header -->
    <div class="honeycomb-top">
      <div class="honeycomb-top__wrap">
        <div class="honeycomb-top__trigger"></div>
        <svg class="honeycomb-top__bg">
          <use xlink:href="/markup/img/sprite.svg#honeycomb"></use>
        </svg>
      </div>
    </div>
    <div class="honeycomb-bottom">
      <div class="honeycomb-bottom__wrap">
        <div class="honeycomb-bottom__trigger"></div>
        <svg class="honeycomb-bottom__bg">
          <use xlink:href="/markup/img/sprite.svg#honeycomb"></use>
        </svg>
      </div>
    </div>
    <div class="middle">
      <div class="about">
        <div class="about__center center">
          <div class="about__wrap">
            <div class="about__container">
              <div class="about__caption">Мы smart-компания из Украины, Киев.
                <br> Будем рады сделать все возможное и невозможное для стремительного подъема Вашего бизнеса на новые горизонты успеха!</div>
              <a href="#" class="about__info">делаем сайты с 1999 года</a>
            </div>
            <div class="about__affirmation">
              <div class="about__affirmation-main">
                <script>var aboutData = {
  0: {
    'label': 'мы утверждаем',
    'caption': 'Мы ваш зонтик в пространстве постоянных изменений в интернет'
  },
  1: {
    'label': 'lorem ipsum dolor',
    'caption': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, sequi!'
  },
  2: {
    'label': 'lorem ipsum dolor sit',
    'caption': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias quis nobis adipisci!'
  },
};</script>
                <div class="about__affirmation-left">
                  <div class="about__affirmation-number"></div>
                  <div class="about__affirmation-label"></div>
                </div>
                <div class="about__affirmation-right">
                  <div class="about__affirmation-inner">
                    <div class="about__affirmation-caption"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="portfolio">
        <div class="portfolio__center center">
          <div class="portfolio__wrap">
            <h4 class="portfolio__description">Несколько наших работ</h4>
          </div>
          <div class="portfolio__list">
            <div class="portfolio__col-left">
              <div class="portfolio__item">
                <a href="#" class="portfolio__main">
                  <div class="portfolio__media">
                    <picture class="portfolio__media-img">
                      <source srcset="/markup/img/portfolio/01.webp" type="image/webp" />
                      <img src="/markup/img/portfolio/01.jpg" alt="" />
                    </picture>
                  </div>
                  <div class="portfolio__content">
                    <div class="portfolio__title">Flora</div>
                    <div class="portfolio__caption">
                      <svg class="portfolio__icon">
                        <use xlink:href="/markup/img/sprite.svg#honeycomb"></use>
                      </svg>
                      <div class="portfolio__info">разработка интернет-магазина</div>
                      <div class="portfolio__info">1024 часа</div>
                      <div class="portfolio__info">8 специалистов</div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="portfolio__item">
                <a href="#" class="portfolio__main">
                  <div class="portfolio__media">
                    <picture class="portfolio__media-img">
                      <source srcset="/markup/img/portfolio/03.webp" type="image/webp" />
                      <img src="/markup/img/portfolio/03.jpg" alt="" />
                    </picture>
                  </div>
                  <div class="portfolio__content">
                    <div class="portfolio__title">Delicia</div>
                    <div class="portfolio__caption">
                      <svg class="portfolio__icon">
                        <use xlink:href="/markup/img/sprite.svg#honeycomb"></use>
                      </svg>
                      <div class="portfolio__info">разработка интернет-магазина</div>
                      <div class="portfolio__info">1024 часа</div>
                      <div class="portfolio__info">8 специалистов</div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="portfolio__col-right">
              <div class="portfolio__item">
                <a href="#" class="portfolio__main">
                  <div class="portfolio__media">
                    <picture class="portfolio__media-img">
                      <source srcset="/markup/img/portfolio/02.webp" type="image/webp" />
                      <img src="/markup/img/portfolio/02.jpg" alt="" />
                    </picture>
                  </div>
                  <div class="portfolio__content">
                    <div class="portfolio__title">Escapehour</div>
                    <div class="portfolio__caption">
                      <svg class="portfolio__icon">
                        <use xlink:href="/markup/img/sprite.svg#honeycomb"></use>
                      </svg>
                      <div class="portfolio__info">разработка интернет-магазина</div>
                      <div class="portfolio__info">1024 часа</div>
                      <div class="portfolio__info">8 специалистов</div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="portfolio__item">
                <a href="#" class="portfolio__main">
                  <div class="portfolio__media">
                    <picture class="portfolio__media-img">
                      <source srcset="/markup/img/portfolio/04.webp" type="image/webp" />
                      <img src="/markup/img/portfolio/04.jpg" alt="" />
                    </picture>
                  </div>
                  <div class="portfolio__content">
                    <div class="portfolio__title">Двухстрочное название</div>
                    <div class="portfolio__caption">
                      <svg class="portfolio__icon">
                        <use xlink:href="/markup/img/sprite.svg#honeycomb"></use>
                      </svg>
                      <div class="portfolio__info">разработка интернет-магазина</div>
                      <div class="portfolio__info">1024 часа</div>
                      <div class="portfolio__info">8 специалистов</div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="our-work">
        <div class="our-work__center center">
          <h4 class="our-work__heading">Наш опыт это 763 сделанных проекта</h4>
          <div class="our-work__list">
            <div class="our-work__item">
              <a href="#" class="our-work__link">Flora</a>
            </div>
            <div class="our-work__item">
              <a href="#" class="our-work__link">Toyota</a>
            </div>
            <div class="our-work__item">
              <a href="#" class="our-work__link">Volkswagen</a>
            </div>
            <div class="our-work__item">
              <a href="#" class="our-work__link">Delicia</a>
            </div>
            <div class="our-work__item">
              <a href="#" class="our-work__link">Escapehour Canada</a>
            </div>
            <div class="our-work__item">
              <a href="#" class="our-work__link">МТС</a>
            </div>
            <div class="our-work__item">
              <a href="#" class="our-work__link">Tempur</a>
            </div>
            <div class="our-work__item">
              <a href="#" class="our-work__link">... и другие</a>
            </div>
          </div>
        </div>
      </div>
      <div class="in-work">
        <div class="in-work__center center">
          <div class="in-work__wrap">
            <div class="in-work__icon"></div>
            <div class="in-work__main">
              <h4 class="in-work__heading">Проекты в работе</h4>
              <div class="in-work__list">
                <div class="in-work__item">
                  <div class="in-work__inner">
                    <div class="in-work__logo">
                      <img src="/markup/img/in-work/cottongin.svg" alt="" class="in-work__logo-img" />
                    </div>
                    <div class="in-work__info">
                      <div class="in-work__title">Интернет-магазин</div>
                      <div class="in-work__caption">Продажа кастомных товаров по всему миру</div>
                    </div>
                  </div>
                </div>
                <div class="in-work__item">
                  <div class="in-work__inner">
                    <div class="in-work__logo">
                      <img src="/markup/img/in-work/flora.svg" alt="" class="in-work__logo-img" />
                    </div>
                    <div class="in-work__info">
                      <div class="in-work__title">Редизайн интернет-магазина</div>
                      <div class="in-work__caption">Продажа кастомных товаров по всему миру</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- footer -->
    <footer class="footer">
      <div class="footer__main">
        <div class="footer__center center">
          <div class="footer__main-container">
            <div class="footer__btn-map">
              <a href="#" class="btn btn-info">Карта сайта</a>
            </div>
            <div class="footer__main-wrap">
              <div class="footer__main-left">
                <nav class="menu-lang">
                  <ul class="menu-lang__list">
                    <li class="menu-lang__item">
                      <a href="#" class="menu-lang__link active">Ru</a>
                    </li>
                    <li class="menu-lang__item">
                      <a href="#" class="menu-lang__link">Ua</a>
                    </li>
                    <li class="menu-lang__item">
                      <a href="#" class="menu-lang__link">En</a>
                    </li>
                  </ul>
                </nav>
              </div>
              <div class="footer__main-right">
                <div class="footer__main-list">
                  <div class="footer__main-item">
                    <div class="footer__phone">
                      <a href="tel:+{{ phoneToInt(conf('contact_phone')) }}" class="footer__phone-link">{{ conf('contact_phone') }}</a>
                    </div>
                    <div class="footer__messenger">
                      <a href="viber://chat?number=+{{ phoneToInt(conf('contact_viber')) }}" class="footer__messenger-link">Viber</a>, 
                      <a href="tg://resolve?domain=+{{ phoneToInt(conf('contact_telegram')) }}" class="footer__messenger-link">Telegram</a>, 
                      <a href="https://wa.me/{{ phoneToInt(conf('contact_whatsapp')) }}" class="footer__messenger-link">WhatsApp</a>
                    </div>
                  </div>
                  <div class="footer__main-item">
                    <div class="footer__email">
                      <a href="maito:{{ conf('contact_email') }}" class="footer__email-link">{{ conf('contact_email') }}</a>
                    </div>
                    <div class="footer__social">
                    @foreach (['facebook', 'youtube'] as $social) 
                      @if (!empty(conf('social_' . $social)))  
                      <a href="{{ conf('social_' . $social) }}" class="footer__social-link">
                        <svg class="footer__social-icon icon-{{ $social }}">
                          <use xlink:href="/markup/img/sprite.svg#{{ $social }}"></use>
                        </svg>
                      </a>
                      @endif
                    @endforeach
                    </div>
                  </div>
                  <div class="footer__main-item">
                    <div class="footer__presentation">
                      <a href="#" class="footer__presentation-link">Презентация
                        <br> Sunbee</a>
                    </div>
                  </div>
                  <div class="footer__main-item">
                    <div class="footer__order">
                      <div class="footer__order-row">
                        <a href="#" class="btn btn-general">Запросить просчет</a>
                      </div>
                      <div class="footer__order-row">
                        <a href="#" class="footer__order-link">Бриф на разработку</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer__info">
        <div class="footer__center center">
          <div class="footer__info-wrap">
            <div class="footer__info-left">
              <div class="footer__copyright">&copy; 2019. Солнечная пчелка
                <br> Все права защищены.</div>
            </div>
            <div class="footer__info-center">
              <div class="footer__welcome">Будем рады знакомству!</div>
            </div>
            <div class="footer__info-right">
              <div class="footer__logo">
                <svg class="footer__logo-img">
                  <use xlink:href="/markup/img/sprite.svg#logo"></use>
                </svg>
                <div class="footer__logo-caption">made in 2019</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer><!-- /.footer -->
  </div>
  <script src="/markup/js/main.js?{{ config('app.version') }}"></script>
</body>

</html>