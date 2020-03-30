<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Http\Requests\Vacancy;

use App\Base\Requests\BaseFormRequest; 
use App\Validators\ImageBase64;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\Vacancy
 *
 * @bodyParam categories  array required  Категорії
 * @bodyParam categories.*  integer required id
 * @bodyParam types  array required  Типи
 * @bodyParam types.*  integer required id
 * @bodyParam locations  array required  Локації
 * @bodyParam locations.*  integer required id
 * @bodyParam is_active  integer required  Активність
 * @bodyParam is_popular  integer required  Популярна
 * @bodyParam rank  integer required  Порядок виводу
 * @bodyParam date_posted  string optional  Дата розміщення
 * @bodyParam hiring_organization  string optional  hiringOrganization
 * @bodyParam image  image optional  Зображення в хедері
 * @bodyParam lang[title]  string required  Заголовок
 * @bodyParam lang[alias]  string optional  Alias
 * @bodyParam lang[salary]  string optional  Заробітна плата
 * @bodyParam lang[work_schedule]  string optional  Графік роботи
 * @bodyParam lang[contract_type]  string optional  Тип договору
 * @bodyParam lang[description]  string optional  Опис
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
        $action = empty($this->vacancy) ? 'store' : 'update';
        
        return $this->user()->hasPermission('vacancy.vacancy.' . $action);
    }
    
    /**
     * @return  array
     */
    public function rules(): array
    {
        $rules = [
            'categories' => [
                'required',
                'array',
            ],
            'categories.*' => [
                'required',
                'integer',
                'exists:vacancy_categories,id',
            ],
            'types' => [
                'required',
                'array',
            ],
            'types.*' => [
                'required',
                'integer',
                'exists:vacancy_types,id',
            ],
            'locations' => [
                'required',
                'array',
            ],
            'locations.*' => [
                'required',
                'integer',
                'exists:vacancy_locations,id',
            ],
            'is_active' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'is_popular' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'rank' => [
                'required',
                'integer',
                'min:0',
            ],
            'date_posted' => [
                'nullable',
                'string',
                'max:255',
            ],
            'hiring_organization' => [
                'nullable',
                'string',
                'max:255',
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
            $rules[$locale.'.salary'] = [
                'nullable',
                'string',
                'max:255',
            ];
            $rules[$locale.'.work_schedule'] = [
                'nullable',
                'string',
                'max:255',
            ];
            $rules[$locale.'.contract_type'] = [
                'nullable',
                'string',
                'max:255',
            ];
            $rules[$locale.'.description'] = [
                'nullable',
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
        return $this->getAttributesLabels('Vacancy', 'Vacancy', true);
    }
}