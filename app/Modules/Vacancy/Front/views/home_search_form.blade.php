<section class="section jumbotron-classic bg-blue-13" style="background-image: url(/markup/images/bg-blue-13-noise.jpg); background-repeat: repeat;">
  <div class="jumbotron-classic-inner">
    <div class="jumbotron-classic-image-left"><img class="wow slideInLeft" src="/markup/images/custom-slide-left-423x629.png" alt=""/>
    </div>
    <div class="jumbotron-classic-image-right"><img class="wow slideInRight" src="/markup/images/custom-slide-right-325x629.png" alt=""/>
    </div>
    <div class="container">
      <div class="jumbotron-classic-header">
        <h2 class="font-weight-light"><?= t('search-by-vacancies')?></h2>
      </div>
      <div class="jumbotron-classic-main">
          <form class="form-layout-search form-lg js-form-search-vacancy" data-url="{{ d_l('/jobs') }}">
            <div class="form-wrap form-wrap-icon">
              <input class="form-input js-q" id="form-keywords" type="text" name="keywords" >
              <label class="form-label" for="form-keywords"><?= t('кeywords')?></label><span class="icon fl-bigmug-line-search74"></span>
            </div>
              
          <div class="form-wrap form-wrap-icon form-wrap-select">
            <!-- Select 2-->
            <select class="form-input js-region" data-placeholder="<?= t('city')?>">
              <option label="<?= t('city')?>"></option>
              @foreach ($locations as $location)
              <option value="<?= d_l('/job-location/' . $location['alias'])?>"><?= $location['title']?></option>
              @endforeach
            </select><span class="icon fl-bigmug-line-big104"></span>
          </div>
          <div class="form-wrap form-wrap-button form-wrap-button-search-md-lg">
            <button class="button button-lg button-primary" type="submit"><?= t('searching')?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>