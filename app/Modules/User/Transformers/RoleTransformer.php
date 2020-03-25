<?php

namespace App\Modules\User\Transformers;

use App\Modules\User\Models\Role;
use App\Base\AbstractTransformer;

/**
 * Class RoleTransformer.
 */
class RoleTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var array
     */
    protected $defaultIncludes = [
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'permissions',
    ];

    /**
     * List of item resource to include
     *
     * @var array
     */
    public $itemIncludes = [
        'permissions',
    ];

    /**
     * transform
     *
     * @param Role $role
     * @return array
     */
    public function transform(Role $role) : array
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'slug' => $role->slug,
            'description' => $role->description,
        ];
    }
    
    /**
     * Include permissions
     *
     * @param EventActivity $eventActivity
     * @return \League\Fractal\Resource\Item
     */
    public function includePermissions(Role $role)
    {
        return $this->primitive($role->permissions->pluck('id')->toArray());
    }
    
    
    
}
