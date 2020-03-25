<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Http\Requests\Category;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Advantage\Models\Category;

/**
 * Class IndexRequest
 * 
 * @package  App\Modules\Advantage
 *
 * @bodyParam  page             integer  optional page
 * @bodyParam  per_page         integer  optional per page
 * @bodyParam  sort_dir         string   optional sorting dir
 * @bodyParam  sort_attr        string   optional sorting attribute
 * @bodyParam  id               integer  optional id
 * @bodyParam  is_active  integer   optional    Active
 * @bodyParam  rank  integer   optional    Rank
 * @bodyParam  title  string   optional    Title
 * @bodyParam  description  string   optional    Short description
;

 */
class IndexRequest extends BaseIndexRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('advantage.category.index');
    }
        
    /*
     * @return  array
     */
    public function rules(): array
    {
        $rules = parent::rules() + [
            'sort_attr' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    'id',
                    'is_active',
                    'rank',
                    'title',
                    'description',
                ]),
            ],
            'is_active' => [
                'nullable',
                'integer',
            ],
            'rank' => [
                'nullable',
                'integer',
            ],
            'title' => [
                'nullable',
                'string',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'id' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ];
        
        return $rules;
    }
        
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Advantage', 'Category') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
        $query = Category::select([
            'advantage_categories.*',
            'advantage_categories_lang.title AS title',
            'advantage_categories_lang.description AS description',
        ])
        ->leftJoin('advantage_categories_lang', 'advantage_categories_lang.category_id', 'advantage_categories.id')
        ->where('advantage_categories_lang.locale', app()->getLocale());

        if ($this->id !== null) {
            $query->where("id", "like", "%{$this->id}%");
        }

        if ($this->is_active !== null) {
            $query->where("is_active", "like", "%{$this->is_active}%");
        }

        if ($this->rank !== null) {
            $query->where("rank", "like", "%{$this->rank}%");
        }

        if ($this->title !== null) {
            $query->where("title", "like", "%{$this->title}%");
        }

        if ($this->description !== null) {
            $query->where("description", "like", "%{$this->description}%");
        }
        
        return $query;
    }

}