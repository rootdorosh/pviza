<?php

namespace App\Modules\Advantage\Front;

use App\Base\WidgetBase;
use App\Modules\Advantage\Models\Advantage;
use App\Modules\Advantage\Models\Category;
use FrontPage;
use App\Modules\Structure\Http\Requests\Block\InsertRequest;

class Widget extends WidgetBase
{
    /*
     * @var string
     */
    public $template;
    
    /*
     * @var int
     */
    public $category_id;
    
    /*
     * @var array
     */
    protected static $dependencies = [
        'categoryFetchService' => 'App\Modules\Advantage\Services\Fetch\CategoryFetchService',
        'advantageFetchService' => 'App\Modules\Advantage\Services\Fetch\AdvantageFetchService',
    ];
    
    /*
     * @return array
     */
    public function getConfig(): array
    {
        return array_merge(parent::getConfig(), [
            [
                'name' => 'template',
                'label' => __('advantage::widget.attributes.template'),
                'type' => 'select',
                'options' => $this->getTemplates(),
            ],
            [
                'name' => 'category_id',
                'label' => __('advantage::widget.attributes.category_id'),
                'type' => 'select',
                'options' => $this->categoryFetchService->getList(),
            ],
        ]);
    }
    
    /*
     * @return array
     */
    public function getActions(): array
    {
        $actions = [];
        foreach (['index'] as $action) {
            $actions[$action] = __('advantage::widget.actions.' . $action);
        }
        
        return $actions;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        $attributes = [];
        foreach (['template', 'category_id'] as $attribute) {
            $attributes[$attribute] = __('advantage::widget.attributes.' . $attribute);
        }
        
        return parent::attributes() + $attributes;
    }

    /**
     * @param InsertRequest $request
     * @return array
     */
    public function rules(InsertRequest $request): array
    {
        return parent::rules($request) + [
            'template' => [
                'required',
                'string',
                'in:' . implode(',', array_keys($this->getTemplates())),
            ],
            'category_id' => [
                'required',
                'integer',                
                'exists:' . (new Category)->table . ',id',                
            ],
        ];
    }

    /**
     * @return array 
     */
    public static function getTemplates(): array
    {
        $templates = [];
        foreach (['with_icons', 'bulleted_list', 'with_tabs'] as $template) {
            $templates[$template] = __('advantage::widget.templates.' . $template);
        }
        
        return $templates;
    }
    
    /*
     * @return string
     */
    public function getName(): string
    {
        return __('advantage::widget.name');        
    }
    
    /*
     */
    public function actionIndex()
    {
        if ($category = $this->categoryFetchService->byId($this->category_id, ['is_active' => 1])) {
            $advantages = $this->advantageFetchService->getItemsByCategoryId($category->id, ['is_active' => 1]);
            if (!empty($advantages)) {
                return $this->view('index', [
                    'category' => $category,
                    'template' => $this->template,
                    'advantages' => $advantages,
                ]);
            }
        }
    }
}
