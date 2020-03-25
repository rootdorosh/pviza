<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Http\Requests\Location;

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
        return $this->user()->hasPermission('vacancy.location.destroy');
    }
}
