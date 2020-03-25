<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Requests\Domain;

use App\Base\Requests\BaseShowRequest;

/**
 * Class ShowRequest
 */
class ShowRequest extends BaseShowRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('structure.domain.update') ||
            $this->user()->hasPermission('menu.menu.index');
    }
}
