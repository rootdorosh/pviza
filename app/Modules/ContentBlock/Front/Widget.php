<?php

namespace App\Modules\ContentBlock\Front;

use App\Base\WidgetBase;
use App\Modules\ContentBlock\Models\ContentBlock;
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
    public $block_id;
    
    /*
     * @var array
     */
    protected static $dependencies = [
        'contentBlockFetchService' => 'App\Modules\ContentBlock\Services\Fetch\ContentBlockFetchService',
    ];
    
    /*
     * @return array
     */
    public function getConfig(): array
    {
        return array_merge(parent::getConfig(), [
            [
                'name' => 'template',
                'label' => __('contentBlock::widget.attributes.template'),
                'type' => 'select',
                'options' => $this->getTemplates(),
            ],
            [
                'name' => 'block_id',
                'label' => __('contentBlock::widget.attributes.block_id'),
                'type' => 'select',
                'options' => $this->contentBlockFetchService->getList(),
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
            $actions[$action] = __('contentBlock::widget.actions.' . $action);
        }
        
        return $actions;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        $attributes = [];
        foreach (['template', 'block_id'] as $attribute) {
            $attributes[$attribute] = __('contentBlock::widget.attributes.' . $attribute);
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
            'block_id' => [
                'required',
                'integer',                
                'exists:' . (new ContentBlock)->table . ',id',                
            ],
        ];
    }

    /**
     * @return array 
     */
    public static function getTemplates(): array
    {
        $templates = [];
        foreach (['empty', 'background_image_title', 'footer_seo_text'] as $template) {
            $templates[$template] = __('contentBlock::widget.templates.' . $template);
        }
        
        return $templates;
    }
    
    /*
     * @return string
     */
    public function getName(): string
    {
        return __('contentBlock::widget.name');        
    }
    
    /*
     * 
     */
    public function actionIndex()
    {
        if ($this->block_id && $block = $this->contentBlockFetchService->byId($this->block_id, ['is_active' => 1])) {
            return $this->view('index', [
                'block' => $block,
                'template' => $this->template,
                'block_id' => $this->block_id,
            ]);
        }
    }
}
