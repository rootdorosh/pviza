<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Http\Requests\Vacancy;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Vacancy\Models\Vacancy;

/**
 * Class IndexRequest
 * 
 * @package  App\Modules\Vacancy
 * 
 * @bodyParam  page    integer  optional  page 
 * @bodyParam  per_page    integer  optional  per page 
 * @bodyParam  sort_dir    string  optional  sorting dir 
 * @bodyParam  sort_attr    string  optional  sorting attribute 
 * @bodyParam  id    integer  optional  id 
 * @bodyParam  is_active    integer  optional  Активність 
 * @bodyParam  is_popular    integer  optional  Популярна 
 * @bodyParam  rank    integer  optional  Порядок виводу 
 * @bodyParam  title    string  optional  Заголовок 
 * @bodyParam  alias    string  optional  Alias
 */

 class IndexRequest extends BaseIndexRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('vacancy.vacancy.index');
    }
    
    /*
     * @return  array
     */
    public function rules(): array
    {
        return parent::rules() + [
            'sort_attr' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    'id',
					'is_active',
					'is_popular',
					'rank',
					'title',
					'alias'
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
            ],
            'categories' => [
                'nullable',
            ],
            'types' => [
                'nullable',
            ],
            'locations' => [
                'nullable',
            ],
            'is_active' => [
                'nullable',
                'integer',
                'in:0,1',
            ],
            'is_popular' => [
                'nullable',
                'integer',
                'in:0,1',
            ],
            'rank' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'date_posted' => [
                'nullable',
                'max:255',
            ],
            'hiring_organization' => [
                'nullable',
                'max:255',
            ],
            'image_base64' => [
                'nullable',
            ],
            'image_name' => [
                'nullable',
                'string',
            ],
            'title' => [
                'nullable',
                'max:255',
            ],
            'alias' => [
                'nullable',
                'max:255',
            ],
            'salary' => [
                'nullable',
                'max:255',
            ],
            'work_schedule' => [
                'nullable',
                'max:255',
            ],
            'contract_type' => [
                'nullable',
                'max:255',
            ],
            'description' => [
                'nullable',
                'max: 10240',
            ],
            'seo_h1' => [
                'nullable',
                'max: 255',
            ],
            'seo_title' => [
                'nullable',
                'max: 255',
            ],
            'seo_description' => [
                'nullable',
                'max: 255',
            ],

        ];
    }
        
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Vacancy', 'Vacancy') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
		$query = Vacancy::select([
			'vacancy.*',
			'vacancy_lang.title AS title',
			'vacancy_lang.alias AS alias'
		])
			->leftJoin('vacancy_lang', 'vacancy_lang.vacancy_id', 'vacancy.id');

		$query->where('vacancy_lang.locale', app()->getLocale());


        if ($this->id !== null) {
            $query->where("vacancy.id", "like", "%{$this->id}%");
        }

        if ($this->is_active !== null) {
            $query->where("vacancy.is_active", "like", "%{$this->is_active}%");
        }

        if ($this->is_popular !== null) {
            $query->where("vacancy.is_popular", "like", "%{$this->is_popular}%");
        }

        if ($this->rank !== null) {
            $query->where("vacancy.rank", "like", "%{$this->rank}%");
        }

        if ($this->title !== null) {
            $query->where("vacancy_lang.title", "like", "%{$this->title}%");
        }

        if ($this->alias !== null) {
            $query->where("vacancy_lang.alias", "like", "%{$this->alias}%");
        }
    
        return $query;
    }

}