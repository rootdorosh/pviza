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
    /*
     * @var array
     */
    protected static $dependencies = [
        'vacancyFetchService' => 'App\Modules\Vacancy\Services\Fetch\VacancyFetchService',
    ];
        
    /*
     * @return array
     */
    public function getActions(): array
    {
        $actions = [];
        foreach (['homeSearchForm', 'index', 'view'] as $action) {
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
        //$items = $this->vacancyFetchService->getItemsGropedByGategories();
        
        return $this->view('index', compact('items'));
    }
    
    public function actionView()
    {
        $vacancy = $this->vacancyFetchService->getByAlias(FrontPage::getVar('alias'));
        if ($vacancy === null) {
            $this->render404();
        }
        
        FrontPage::setTitle(!empty($vacancy->seo_title) ? $vacancy->seo_title : $vacancy->title)
            ->setDescription(!empty($vacancy->seo_description) ? $vacancy->seo_description : $vacancy->title)
            ->setH1(!empty($vacancy->seo_h1) ? $vacancy->seo_h1 : $vacancy->title);
                
        return $this->view('vacancy_' . $vacancy->getTemplateAlias(), compact('vacancy'));
    }
}
