<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Requests\Block;

use App\Base\Requests\BaseSimpleRequest;

/**
 * Class MetaRequest
 */
class IndexRequest extends BaseSimpleRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('structure.block.index');
    }
}
