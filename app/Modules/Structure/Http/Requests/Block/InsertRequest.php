<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Requests\Block;

use App\Base\Requests\BaseFormRequest;
use App\Base\ScmsHelper;

/**
 * Class InsertRequest
 * 
 * @package App\Modules\Structure
 *
 * @bodyParam alias     string  required Template area Alias.
 * @bodyParam widget_id string  required Widget id
 */
class InsertRequest extends BaseFormRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('structure.block.insert');
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'alias' => [
                'required',
                'string',
            ],           
            'widget_id' => [
                'required',
                'string',
                'in:' . implode(',', ScmsHelper::getWidgetsIds()),
            ],
        ];
        
        if ($this->hasWidgetIdValid()) {
            $rules = $rules + ScmsHelper::getWidgetInstance($this->widget_id)->rules($this);
        }
        
        return $rules;
    }
    
    /*
     * @return array
     */
    public function attributes(): array
    {
        $attributes = $this->getAttributesLabels('Structure', 'Block');
        
        if ($this->hasWidgetIdValid()) {
            $attributes = $attributes + ScmsHelper::getWidgetInstance($this->widget_id)->attributes();
        }
        return $attributes;
    }
    
    /*
     * @return bool 
     */
    private function hasWidgetIdValid(): bool
    {
        return (!empty($this->widget_id) && in_array($this->widget_id, ScmsHelper::getWidgetsIds()));
    }

}