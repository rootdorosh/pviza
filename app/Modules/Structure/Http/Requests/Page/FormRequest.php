<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Requests\Page;

use Illuminate\Support\Arr;
use App\Base\Requests\BaseFormRequest;
use App\Modules\Structure\Services\StructureService;

/**
 * Class FormRequest
 * 
 * @package App\Modules\Structure
 *
 * @bodyParam alias                     string   required Alias.
 * @bodyParam is_search                 integer  required Search
 * @bodyParam is_canonical              integer  required Canonical
 * @bodyParam is_breadcrumbs            integer  required Breadcrumbs
 * @bodyParam is_menu                   integer  required Menu
 * @bodyParam template_id               integer  required Template
 * @bodyParam parent_id                 integer  required Parent page - required only action store
 * @bodyParam body_class                string   optional Body class
 * @bodyParam lang[seo_title]           string   required Seo title
 * @bodyParam lang[seo_h1]              string   optional Seo h1
 * @bodyParam lang[seo_description]     string   optional Seo description
 * @bodyParam lang[breacrumbs_title]    string   optional Breacrumbs title
 * @bodyParam lang[head]                string   optional head
 */

class FormRequest extends BaseFormRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        $action = empty($this->event) ? 'store' : 'update';
        
        return $this->user()->hasPermission('structure.page.' . $action);
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
            'template_id' => [
                'required',
                'integer',
                'in:' . implode(',', Arr::pluck(StructureService::TEMPLATES, 'id', 'id')),
            ],
            'is_canonical' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'is_breadcrumbs' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'is_menu' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'body_class' => [
                'nullable',
                'string',
            ],
        ];

        // store
        if (empty($this->page)) {
            $rules['parent_id'] = [
                'required',
                'integer',
                'exists:structure_pages,id', //TODO add where domain_id = $this->domain->id                
            ];
        }
        
        foreach (config('translatable.locales') as $locale) {
            $rules = $rules + [
                $locale . '.seo_title' => [
                    'required',
                    'string',
                ],
                $locale . '.seo_h1' => [
                    'nullable',
                    'string',
                ],
                $locale . '.seo_description' => [
                    'nullable',
                    'string',
                ],
                $locale . '.breacrumbs_title' => [
                    'nullable',
                    'string',
                ],
                $locale . '.head' => [
                    'nullable',
                    'string',
                ],
            ];
        }
        
        return $rules;
    }
    
    /*
     * @return array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Structure', 'Page', true);
    }
}
