<?php 
$locations = (new \App\Modules\Vacancy\Services\Fetch\VacancyFetchService)->getLocations();
?>

<form class="form-layout-search form-lg js-form-search-vacancy" data-url="{{ d_l('/jobs') }}">
    <div class="form-wrap form-wrap-icon">
        <input class="form-input js-q" id="form-employer" type="text" name="q" value="{{ request()->input('q') }}">
        <label class="form-label" for="form-employer"><?= t('кeywords')?></label><span class="icon fl-bigmug-line-search74"></span>
    </div>
    <div class="form-wrap form-wrap-icon form-wrap-select">
        <!-- Select 2-->
        <select class="form-input select js-region" id="form-region" data-placeholder="<?= t('city')?>">
            <option value=""><?= t('all-cities')?></option>
            @foreach ($locations as $item)
            <option {!! (isset($location)) && $location->id == $item['id'] ? 'selected="selected"' : ''  !!} value="<?= d_l('/job-location/' . $item['alias'])?>"><?= $item['title']?></option>
            @endforeach
        </select><span class="icon fl-bigmug-line-big104"></span>
    </div>
    <div class="form-wrap form-wrap-button">
        <button class="button button-lg button-primary" type="submit"><?= t('searching')?></button>
    </div>
</form>

