<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Requests\Page;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexSimpleRequest;
use App\Modules\Structure\Models\Page;

/**
 * Class IndexRequest
 * 
 * @package App\Modules\Structure
 *
 */
class IndexRequest extends BaseIndexSimpleRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('structure.page.index') ||
            $this->user()->hasPermission('menu.menu.index');
    }
}