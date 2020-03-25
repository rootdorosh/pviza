<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Http\Requests\Location;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Vacancy\Models\Location;

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
        return $this->user()->hasPermission('vacancy.location.index');
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
					'rank',
					'title',
					'alias'
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
            ],
            'is_active' => [
                'nullable',
                'integer',
                'in:0,1',
            ],
            'rank' => [
                'nullable',
                'integer',
                'min:0',
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
            'description' => [
                'nullable',
                'max: 1024',
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
        return $this->getAttributesLabels('Vacancy', 'Location') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
		$query = Location::select([
			'vacancy_locations.*',
			'vacancy_locations_lang.title AS title',
			'vacancy_locations_lang.alias AS alias'
		])
			->leftJoin('vacancy_locations_lang', 'vacancy_locations_lang.category_id', 'vacancy_locations.id');

		$query->where('vacancy_locations_lang.locale', app()->getLocale());


        if ($this->id !== null) {
            $query->where("vacancy_locations.id", "like", "%{$this->id}%");
        }

        if ($this->is_active !== null) {
            $query->where("vacancy_locations.is_active", "like", "%{$this->is_active}%");
        }

        if ($this->rank !== null) {
            $query->where("vacancy_locations.rank", "like", "%{$this->rank}%");
        }

        if ($this->title !== null) {
            $query->where("vacancy_locations_lang.title", "like", "%{$this->title}%");
        }

        if ($this->alias !== null) {
            $query->where("vacancy_locations_lang.alias", "like", "%{$this->alias}%");
        }
    
        return $query;
    }

}