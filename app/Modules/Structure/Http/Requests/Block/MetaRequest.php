<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Requests\Block;

use App\Base\Requests\BaseMetaRequest;

/**
 * Class MetaRequest
 */
class MetaRequest extends BaseMetaRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('structure.block.index');
    }
}
