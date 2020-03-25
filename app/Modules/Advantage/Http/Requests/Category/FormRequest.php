<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Http\Requests\Category;

use App\Base\Requests\BaseFormRequest;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\Advantage
 *
 * @bodyParam  is_active  integer  required Active
 * @bodyParam  rank  integer  required Rank
 * @bodyParam  lang[title]  string  required Title
 * @bodyParam  lang[description]  string  optional Short description
 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        $action = empty($this->category) ? 'store' : 'update';
        
        return $this->user()->hasPermission('advantage.category.' . $action);
    }
    
    /**
     * @return  array
     */
    public function rules(): array
    {
        $rules = [
            'is_active' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'rank' => [
                'required',
                'integer',
                'min:0',
            ],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.title'] = [
                'required',
                'string',
                'max:255',
            ];
            $rules[$locale.'.description'] = [
                'nullable',
                'string',
                'max: 1024',
            ];
        }

		return $rules;
	}
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Advantage', 'Category', true);
    }
}