<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Http\Requests\Vacancy;

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
        return $this->user()->hasPermission('vacancy.vacancy.destroy');
    }
}
