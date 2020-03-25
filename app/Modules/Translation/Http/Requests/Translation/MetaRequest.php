<?php 

declare( strict_types = 1 );

namespace App\Modules\Translation\Http\Requests\Translation;

use App\Base\Requests\BaseShowRequest;

/**
 * Class MetaRequest
 */
class MetaRequest extends BaseShowRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('translation.translation.index');
    }
}
