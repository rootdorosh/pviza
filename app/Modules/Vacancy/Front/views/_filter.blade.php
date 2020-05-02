<?php 
use App\Modules\Vacancy\Services\Fetch\VacancyFetchService;
$fetcher = new VacancyFetchService;

?>

<div class="col-sm-6 col-lg-12">
    <p class="heading-8">{{ t('categories-of-vacancies') }}</p>
    <hr>
    <ul class="list list-xs">
    @foreach ($fetcher->getFilterCategories() as $item)    
        <li>
            <a href="{{ d_l('/job-category/' . $item['alias']) }}" 
               class="text-blue-11 {!! (isset($category)) && $category->id == $item['id'] ? 'active' : ''  !!}">{{ $item['title'] }} ({{ $item['c'] }})</a>
        </li>
    @endforeach 
    </ul>
</div>

<div class="col-sm-6 col-lg-12">
    <p class="heading-8">{{ t('types-of-jobs') }}</p>
    <hr>
    <ul class="list list-xs">
    @foreach ($fetcher->getFilterTypes() as $item)    
        <li>
            <a href="{{ d_l('/job-type/' . $item['alias']) }}" 
               class="text-blue-11 {!! (isset($type)) && $type->id == $item['id'] ? 'active' : ''  !!}">{{ $item['title'] }} ({{ $item['c'] }})</a>
        </li>
    @endforeach   
    </ul>
</div>

<div class="col-sm-6 col-lg-12">
    <p class="heading-8">{{ t('locations-of-jobs') }}</p>
    <hr>
    <ul class="list list-xs">
    @foreach ($fetcher->getFilterLocations() as $item)    
        <li>
            <a href="{{ d_l('/job-location/' . $item['alias']) }}" 
              class="text-blue-11 {!! (isset($location)) && $location->id == $item['id'] ? 'active' : ''  !!}">{{ $item['title'] }} ({{ $item['c'] }})</a>
        </li>
    @endforeach   
    </ul>
</div>