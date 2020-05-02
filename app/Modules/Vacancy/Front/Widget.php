<?php

namespace App\Modules\Vacancy\Front;

use Illuminate\Support\Str;
use App\Base\WidgetBase;
use App\Modules\Vacancy\Models\Vacancy;
use App\Modules\Vacancy\Models\Category;
use FrontPage;
use App\Modules\Structure\Http\Requests\Block\InsertRequest;

class Widget extends WidgetBase
{   
    const LIMIT = 10;
    
    /*
     * @var array
     */
    protected static $dependencies = [
        'vacancyFetchService' => 'App\Modules\Vacancy\Services\Fetch\VacancyFetchService',
        'locationFetchService' => 'App\Modules\Vacancy\Services\Fetch\LocationFetchService',
        'typeFetchService' => 'App\Modules\Vacancy\Services\Fetch\TypeFetchService',
        'categoryFetchService' => 'App\Modules\Vacancy\Services\Fetch\CategoryFetchService',
    ];
        
    /*
     * @return array
     */
    public function getActions(): array
    {
        $actions = [];
        foreach ([
            'homeSearchForm', 
            'index', 
            'location', 
            'category', 
            'type', 
            'view'
        ] as $action) {
            $actions[$action] = __('vacancy::widget.actions.' . Str::snake($action));
        }
        
        return $actions;
    }
    
    /*
     * @return string
     */
    public function getName(): string
    {
        return __('vacancy::widget.name');        
    }
    
    public function actionHomeSearchForm()
    {
        $locations = $this->vacancyFetchService->getLocations();
        
        return $this->view('home_search_form', compact('locations'));
    }
    
    public function actionIndex()
    {
        $page = FrontPage::getVar('page', 1);
        $limit = self::LIMIT;
        
        $items = $this->vacancyFetchService->getItems([
            'q' => request()->input('q'),
            'location_id' => request()->input('location_id'),
            'page' => $page,
            'limit' => $limit,
        ]);
        
        $count = $this->vacancyFetchService->getCountItems([
            'q' => request()->input('q'),
        ]);
        
        return $this->view('index', compact('items', 'count', 'limit'));
    }
    
    public function actionLocation()
    {
        $location = $this->locationFetchService->getByAlias(FrontPage::getVar('alias'));
        if ($location === null) {
            $this->render404();
        }
        
        FrontPage::setTitle(!empty($location->seo_title) ? $location->seo_title : $location->title)
            ->setDescription(!empty($location->seo_description) ? $location->seo_description : $location->title)
            ->setH1(!empty($location->seo_h1) ? $location->seo_h1 : $location->title)
            ->setLangLinksMap($this->locationFetchService->getLangMapLinks($location->id));

        $page = FrontPage::getVar('page', 1);
        $limit = self::LIMIT;
        
        $items = $this->vacancyFetchService->getItems([
            'q' => request()->input('q'),
            'location_id' => $location->id,
            'page' => $page,
            'limit' => $limit,
        ]);
        
        $count = $this->vacancyFetchService->getCountItems([
            'q' => request()->input('q'),
        ]);
        
        return $this->view('location', compact('location', 'items', 'count', 'limit'));
    }
    
    public function actionCategory()
    {
        $category = $this->categoryFetchService->getByAlias(FrontPage::getVar('alias'));
        if ($category === null) {
            $this->render404();
        }
        
        FrontPage::setTitle(!empty($category->seo_title) ? $category->seo_title : $category->title)
            ->setDescription(!empty($category->seo_description) ? $category->seo_description : $category->title)
            ->setH1(!empty($category->seo_h1) ? $category->seo_h1 : $category->title)
            ->setLangLinksMap($this->categoryFetchService->getLangMapLinks($category->id));

        $page = FrontPage::getVar('page', 1);
        $limit = self::LIMIT;
        
        $items = $this->vacancyFetchService->getItems([
            'q' => request()->input('q'),
            'category_id' => $category->id,
            'page' => $page,
            'limit' => $limit,
        ]);
        
        $count = $this->vacancyFetchService->getCountItems([
            'q' => request()->input('q'),
        ]);
        
        return $this->view('category', compact('category', 'items', 'count', 'limit'));
    }

    public function actionType()
    {
        $type = $this->typeFetchService->getByAlias(FrontPage::getVar('alias'));
        if ($type === null) {
            $this->render404();
        }
        
        FrontPage::setTitle(!empty($type->seo_title) ? $type->seo_title : $type->title)
            ->setDescription(!empty($type->seo_description) ? $type->seo_description : $type->title)
            ->setH1(!empty($type->seo_h1) ? $type->seo_h1 : $type->title)
            ->setLangLinksMap($this->typeFetchService->getLangMapLinks($type->id));

        $page = FrontPage::getVar('page', 1);
        $limit = self::LIMIT;
        
        $items = $this->vacancyFetchService->getItems([
            'q' => request()->input('q'),
            'type_id' => $type->id,
            'page' => $page,
            'limit' => $limit,
        ]);
        
        $count = $this->vacancyFetchService->getCountItems([
            'q' => request()->input('q'),
        ]);
        
        return $this->view('type', compact('type', 'items', 'count', 'limit'));
    }

    public function actionView()
    {
        $vacancy = $this->vacancyFetchService->getByAlias(FrontPage::getVar('alias'));
        if ($vacancy === null) {
            $this->render404();
        }
        
        FrontPage::setTitle(!empty($vacancy->seo_title) ? $vacancy->seo_title : $vacancy->title)
            ->setDescription(!empty($vacancy->seo_description) ? $vacancy->seo_description : $vacancy->title)
            ->setH1(!empty($vacancy->seo_h1) ? $vacancy->seo_h1 : $vacancy->title)
            ->setLangLinksMap($this->vacancyFetchService->getLangMapLinks($vacancy->id));
               
        return $this->view('view', compact('vacancy'));
    }
}
