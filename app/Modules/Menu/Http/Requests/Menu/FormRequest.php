<?php 

declare( strict_types = 1 );

namespace App\Modules\Menu\Http\Requests\Menu;

use App\Base\Requests\BaseFormRequest;
use App\Modules\Menu\Http\Validators\Items;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\Menu
 *
 * @bodyParam  domain_id  integer  required Domain
 * @bodyParam  title  string  required Title
 * @bodyParam  is_active  integer  required Active
 * @bodyParam  is_sitemap  integer  required Sitemap
 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        $action = empty($this->menu) ? 'store' : 'update';
        
        return $this->user()->hasPermission('menu.menu.' . $action);
    }
    
    /**
     * @return  array
     */
    public function rules(): array
    {
        $rules = [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'is_active' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'is_sitemap' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'items' => [
                'required',
                //new Items($this),
            ],
            'items.*' => [
                'required',
                //new Items($this),
            ],
        ];
        
        if (empty($this->menu)) {
            $rules['domain_id'] = [
                'required',
                'integer',
                'integer',
                'exists:structure_domains,id',
            ];            
        }
                
        return $rules;
    }
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Menu', 'Menu');
    }
}