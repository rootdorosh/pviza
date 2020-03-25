<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Http\Requests\Location;

use App\Base\Requests\BaseShowRequest;

/**
 * Class ShowRequest
 */
class ShowRequest extends BaseShowRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('vacancy.location.update');
    }
}
