<?php
declare( strict_types = 1 );

namespace App\Modules\User\Http\Requests\Role;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\User\Models\Role;

/**
 * Class IndexRequest
 * 
 * @package App\Modules\User
 *
 * @bodyParam page             integer  optional page
 * @bodyParam per_page         integer  optional per page
 * @bodyParam sort_dir         string   optional sorting dir
 * @bodyParam sort_attr        string   optional sorting attribute
 * @bodyParam id               integer  optional id
 * @bodyParam name             string   optional name.
 * @bodyParam slug             string   optional slug.
 * @bodyParam description      string   optional description.
 */
class IndexRequest extends BaseIndexRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('user.role.index');
    }

    /*
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules() + [
            'sort_attr' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    'id',
                    'slug',
                    'name',
                    'description',
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'slug' => [
                'nullable',
                'string',
            ],
            'name' => [
                'nullable',
                'string',
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ];
        
        return $rules;
    }
        
    /*
     * @return array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('User', 'Role') + parent::attributes();
    }
    
    /*
     * @return Builder
     */
    public function getQueryBuilder() : Builder
    {
        $query = Role::query();
        
        if ($this->id !== null) {
            $query->where('id', 'like', "%{$this->id}%");
        }
        if ($this->name !== null) {
            $query->where('name', 'like', "%{$this->name}%");
        }
        if ($this->slug !== null) {
            $query->where('slug', 'like', "%{$this->slug}%");
        }
        if ($this->description !== null) {
            $query->where('description', 'like', "%{$this->description}%");
        }
         
        return $query;
    }

    public function paginate()
    {
        $query = $this->getQueryBuilder();

        $sortDir = $this->attr('sort_dir');
        $sortAttr = $this->attr('sort_attr');
        if ($sortDir && $sortAttr) {
            $query->orderBy($sortAttr, $sortDir);
        }

        $perPage = $this->attr('per_page', self::PER_PAGE);
        $page = $this->attr('page', self::PAGE);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}