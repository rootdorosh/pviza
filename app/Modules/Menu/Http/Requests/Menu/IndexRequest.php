<?php 

declare( strict_types = 1 );

namespace App\Modules\Menu\Http\Requests\Menu;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Menu\Models\Menu;

/**
 * Class IndexRequest
 * 
 * @package  App\Modules\Menu
 *
 * @bodyParam  page             integer  optional page
 * @bodyParam  per_page         integer  optional per page
 * @bodyParam  sort_dir         string   optional sorting dir
 * @bodyParam  sort_attr        string   optional sorting attribute
 * @bodyParam  id               integer  optional id
 * @bodyParam  is_active  integer   optional    Active
 * @bodyParam  is_sitemap  integer   optional    Sitemap
;

 */
class IndexRequest extends BaseIndexRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('menu.menu.index');
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
                    'title',
                    'is_active',
                    'is_sitemap',
                ]),
            ],
            'title' => [
                'nullable',
            ],
            'is_active' => [
                'nullable',
                'integer',
            ],
            'is_sitemap' => [
                'nullable',
                'integer',
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
        return $this->getAttributesLabels('Menu', 'Menu') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
        $query = Menu::query();
        if ($this->id !== null) {
            $query->where("id", "like", "%{$this->id}%");
        }

        if ($this->is_active !== null) {
            $query->where("is_active", $this->is_active);
        }

        if ($this->is_sitemap !== null) {
            $query->where("is_sitemap", $this->is_sitemap);
        }
        
        if ($this->title !== null) {
            $query->where("title", "like", "%{$this->title}%");
        }
        
        return $query;
    }

}