<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Http\Requests\Advantage;

use App\Base\Requests\BaseFormRequest;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\Advantage
 *
 * @bodyParam  category_id  integer  required Category
 * @bodyParam  image  image  optional Image
 * @bodyParam  is_active  integer  required Active
 * @bodyParam  rank  integer  required Rank
 * @bodyParam  svg_code  string  optional SVG code
 * @bodyParam  lang[title]  string  required Title
 * @bodyParam  lang[description]  string  optional Short description
 * @bodyParam  lang[body]  string  required Body
 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        $action = empty($this->advantage) ? 'store' : 'update';
        
        return $this->user()->hasPermission('advantage.advantage.' . $action);
    }
    
    /**
     * @return  array
     */
    public function rules(): array
    {
        $rules = [
            'category_id' => [
                'required',
                'integer',
                'exists:advantage_categories,id',
            ],
            'image_base64' => [
                'nullable',
                'string',
                'base64dimensions:min_width=400,min_height=300',
            ],
            'image_name' => [
                'nullable',
                'string',
            ],
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
            'svg_code' => [
                'nullable',
                'string',
                'max: 10024',
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
            $rules[$locale.'.body'] = [
                'nullable',
                'string',
                'max: 10024',
            ];
        }

		return $rules;
	}
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Advantage', 'Advantage', true);
    }
}