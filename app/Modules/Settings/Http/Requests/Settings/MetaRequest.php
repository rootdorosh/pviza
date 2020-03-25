<?php 

declare( strict_types = 1 );

namespace App\Modules\Settings\Http\Requests\Settings;

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
        return $this->user()->hasPermission('settings.settings.index');
    }
}
