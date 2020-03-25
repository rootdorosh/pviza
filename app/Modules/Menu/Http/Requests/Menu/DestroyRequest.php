<?php 

declare( strict_types = 1 );

namespace App\Modules\Menu\Http\Requests\Menu;

use App\Base\Requests\BaseDestroyRequest;

/**
 * Class DestroyRequest
 */
class DestroyRequest extends BaseDestroyRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('menu.menu.destroy');
    }
}
