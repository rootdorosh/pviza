<?php

namespace App\Modules\User\Transformers;

use App\Modules\User\Models\User;
use App\Base\AbstractTransformer;
/**
 * Class UserTransformer.
 */
class UserTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var array
     */
    protected $defaultIncludes = [
        'image',
        'name_roles',
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'image',
        'name_roles',
        'roles',
        'events',
    ];

    /**
     * List of item resource to include
     *
     * @var array
     */
    public $itemIncludes = [
        'image',
        'roles',
        'events',
    ];

    /**
     * transform
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user) : array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'is_active' => $user->is_active,
            'email' => $user->email,
            'position' => $user->position,
            'created_at' => (string) $user->created_at,
            'updated_at' => (string) $user->updated_at,
        ];
    }
    
    /**
     * Include image
     *
     * @return \League\Fractal\Resource\Item
     */

    public function includeImage(User $user)
    {
        return $this->primitive($user->getThumb('image', '60', '80'));
    }

    /**
     * Include name_roles
     *
     * @return \League\Fractal\Resource\Item
     */

    public function includeNameRoles(User $user)
    {
        return $this->primitive($user->name_roles);
    }
    
    /**
     * Include roles
     *
     * @param EventActivity $eventActivity
     * @return \League\Fractal\Resource\Item
     */
    public function includeRoles(User $user)
    {
        return $this->primitive($user->roles->pluck('id')->toArray());
    }
    
    /**
     * Include events
     *
     * @param EventActivity $eventActivity
     * @return \League\Fractal\Resource\Item
     */
    public function includeEvents(User $user)
    {
        return $this->primitive($user->events->pluck('id')->toArray());
    }
    
}
