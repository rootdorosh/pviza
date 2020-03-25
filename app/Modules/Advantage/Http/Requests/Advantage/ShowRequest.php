<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Http\Requests\Advantage;

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
        return $this->user()->hasPermission('advantage.advantage.update');
    }
}
