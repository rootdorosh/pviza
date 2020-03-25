<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Http\Requests\Advantage;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Advantage\Models\Advantage;

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
 * @bodyParam  category_title   string   optional    Category
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
        return $this->user()->hasPermission('advantage.advantage.index');
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
                    'category_title',
                    'is_active',
                    'rank',
                    'title',
                    'description',
                ]),
            ],
            'category_title' => [
                'nullable',
                'integer',
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
        return $this->getAttributesLabels('Advantage', 'Advantage') + parent::attributes();
    }
    
    /**
     * @return array
     */
    public static function sortAttrMap(): array
    {
        return [
            'category_title' => 'advantage_categories_lang.title',
        ];
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
        $query = Advantage::select([
            'advantage.*',
            'advantage_lang.title AS title',
            'advantage_lang.description AS description',
        ])
        ->leftJoin('advantage_lang', 'advantage_lang.advantage_id', 'advantage.id')
        ->leftJoin('advantage_categories', 'advantage_categories.id', 'advantage.category_id')
        ->leftJoin('advantage_categories_lang', 'advantage_categories_lang.category_id', 'advantage_categories.id')
        ->where('advantage_lang.locale', app()->getLocale())
        ->where('advantage_categories_lang.locale', app()->getLocale());

        if ($this->id !== null) {
            $query->where("advantage.id", "like", "%{$this->id}%");
        }
        
        if ($this->category_title !== null) {
            $query->where("advantage_categories.id", $this->category_title);
        }

        if ($this->is_active !== null) {
            $query->where("advantage.is_active", "like", "%{$this->is_active}%");
        }

        if ($this->rank !== null) {
            $query->where("advantage.rank", "like", "%{$this->rank}%");
        }

        if ($this->title !== null) {
            $query->where("advantage_lang.title", "like", "%{$this->title}%");
        }

        if ($this->description !== null) {
            $query->where("advantage_lang.description", "like", "%{$this->description}%");
        }
        
        return $query;
    }

}