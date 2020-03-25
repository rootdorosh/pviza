<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Http\Requests\ContentBlock;

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
        return $this->user()->hasPermission('contentblock.contentblock.destroy');
    }
}
