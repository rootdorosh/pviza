<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Requests\Block;

use App\Base\Requests\BaseSimpleRequest;

/**
 * Class ShowRequest
 * 
 * @package App\Modules\Structure
 *
 * @bodyParam alias     string  required Template area Alias.
 */
class ShowRequest extends BaseSimpleRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('structure.block.index');
    }        
}
