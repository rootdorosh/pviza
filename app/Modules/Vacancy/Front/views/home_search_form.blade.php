<section class="section jumbotron-classic bg-blue-13" style="background-image: url(/markup/images/bg-blue-13-noise.jpg); background-repeat: repeat;">
  <div class="jumbotron-classic-inner">
    <div class="jumbotron-classic-image-left"><img class="wow slideInLeft" src="/markup/images/custom-slide-left-423x629.png" alt=""/>
    </div>
    <div class="jumbotron-classic-image-right"><img class="wow slideInRight" src="/markup/images/custom-slide-right-325x629.png" alt=""/>
    </div>
    <div class="container">
      <div class="jumbotron-classic-header">
        <h2 class="font-weight-light"><?= t('')?>Пошук по вакансіях</h2>
      </div>
      <div class="jumbotron-classic-main">
          <form class="form-layout-search form-lg" action="<?= d_l('/jobs')?>">
          <div class="form-wrap form-wrap-icon">
            <input class="form-input" id="form-keywords" type="text" name="keywords">
            <label class="form-label" for="form-keywords"><?= t('кeywords')?></label><span class="icon fl-bigmug-line-search74"></span>
          </div>
          <div class="form-wrap form-wrap-icon form-wrap-select">
            <!-- Select 2-->
            <select class="form-input select" id="form-region" data-placeholder="<?= t('city')?>" name="city_id">
              <option label="<?= t('city')?>"></option>
              @foreach ($locations as $location)
              <option value="<?= $location['id']?>"><?= $location['title']?></option>
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