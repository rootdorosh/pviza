<?php

namespace App\Modules\Menu\Front;

use App\Base\WidgetBase;
use App\Modules\Menu\Models\Menu;
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
    public $menu_id;
    
    /*
     * @var array
     */
    protected static $dependencies = [
        'menuFetchService' => 'App\Modules\Menu\Services\Fetch\MenuFetchService',
        'menuFetchService' => 'App\Modules\Menu\Services\Fetch\MenuFetchService',
        'menuService' => 'App\Modules\Menu\Services\MenuService',
    ];
    
    /*
     * @return array
     */
    public function getConfig(): array
    {
        return array_merge(parent::getConfig(), [
            [
                'name' => 'template',
                'label' => __('menu::widget.attributes.template'),
                'type' => 'select',
                'options' => $this->getTemplates(),
            ],
            [
                'name' => 'menu_id',
                'label' => __('menu::widget.attributes.menu_id'),
                'type' => 'select',
                'options' => $this->menuFetchService->getList(),
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
            $actions[$action] = __('menu::widget.actions.' . $action);
        }
        
        return $actions;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        $attributes = [];
        foreach (['template', 'menu_id'] as $attribute) {
            $attributes[$attribute] = __('menu::widget.attributes.' . $attribute);
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
            'menu_id' => [
                'required',
                'integer',                
                'exists:' . (new Menu)->table . ',id',                
            ],
        ];
    }

    /**
     * @return array 
     */
    public static function getTemplates(): array
    {
        $templates = [];
        foreach (['header', 'footer'] as $template) {
            $templates[$template] = __('menu::widget.templates.' . $template);
        }
        
        return $templates;
    }
    
    /*
     * @return string
     */
    public function getName(): string
    {
        return __('menu::widget.name');        
    }
    
    /*
     * Action index
     */
    public function actionIndex()
    {
        if ($this->menu_id && 
            $items = $this->menuFetchService->getItems(FrontPage::getDomain(), $this->menu_id, ['is_active' => 1])
        ) {    
            return $this->view($this->template, [
                'items' => $this->menuService->setActive($items),
            ]);
        }
    }
}
