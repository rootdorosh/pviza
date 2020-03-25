<?php
declare( strict_types = 1 );

namespace App\Modules\User\Http\Requests\User;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\User\Models\User;
use DB;

/**
 * Class IndexRequest
 * 
 * @package App\Modules\User
 *
 * @bodyParam page          integer  optional page
 * @bodyParam per_page      integer  optional per page
 * @bodyParam sort_dir      string   optional sorting dir
 * @bodyParam sort_attr     string   optional sorting attribute
 * @bodyParam name          string   optional name.
 * @bodyParam email         string   optional email.
 * @bodyParam is_active     integer  optional active.
 * @bodyParam position      string   optional user position
 */
class IndexRequest extends BaseIndexRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('user.user.index');
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
                    'name',
                    'email',
                    'position',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'name' => [
                'nullable',
                'string',
            ],
            'email' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'nullable',
                'integer',
                'in:0,1',
            ],
            'position' => [
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
        return $this->getAttributesLabels('User', 'User') + parent::attributes();
    }
    
    /*
     * @return Builder
     */
    public function getQueryBuilder() : Builder
    {
        $query = User::select([
            'users.*',
            DB::raw('GROUP_CONCAT(DISTINCT users_roles.name ORDER BY users_roles.name) AS name_roles'),            
        ]);
        
        $query->leftJoin('users_vs_roles', 'users_vs_roles.user_id', 'users.id')
            ->leftJoin('users_roles', 'users_roles.id', 'users_vs_roles.role_id');
        
        if ($this->id !== null) {
            $query->where('id', 'like', "%{$this->id}%");
        }
        if ($this->name !== null) {
            $query->where('name', 'like', "%{$this->name}%");
        }
        if ($this->position !== null) {
            $query->where('position', 'like', "%{$this->position}%");
        }
        if ($this->email !== null) {
            $query->where('email', 'like', "%{$this->email}%");
        }
        if ($this->is_active !== null) {
            $query->where('is_active', $this->is_active);
        }
        
        $query->groupBy('users.id');
         
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