<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Http\Requests\Location;

use App\Base\Requests\BaseFormRequest; 
use App\Validators\ImageBase64;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\Vacancy
 *
 * @bodyParam is_active  integer required  Активність
 * @bodyParam rank  integer required  Порядок виводу
 * @bodyParam image  image optional  Зображення в хедері
 * @bodyParam lang[title]  string required  Заголовок
 * @bodyParam lang[alias]  string optional  Alias
 * @bodyParam lang[description]  string required  Опис
 * @bodyParam lang[seo_h1]  string optional  seo h1
 * @bodyParam lang[seo_title]  string optional  meta title
 * @bodyParam lang[seo_description]  string optional  meta description

 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        $action = empty($this->location) ? 'store' : 'update';
        
        return $this->user()->hasPermission('vacancy.location.' . $action);
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
            'image.content' => [
                'nullable',
                'string',
                new ImageBase64(),
            ],
            'image' => [
                'nullable',
            ],
            'image.name' => [
                'nullable',
                'string',
            ],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.title'] = [
                'required',
                'string',
                'max:255',
            ];
            $rules[$locale.'.alias'] = [
                'nullable',
                'string',
                'max:255',
            ];
            $rules[$locale.'.description'] = [
                'required',
                'string',
            ];
            $rules[$locale.'.seo_h1'] = [
                'nullable',
                'string',
                'max: 255',
            ];
            $rules[$locale.'.seo_title'] = [
                'nullable',
                'string',
                'max: 255',
            ];
            $rules[$locale.'.seo_description'] = [
                'nullable',
                'string',
                'max: 255',
            ];
        }

		return $rules;
	}
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Vacancy', 'Location', true);
    }
}