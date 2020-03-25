<?php 
use Illuminate\Support\Str;
?>

declare( strict_types = 1 );

namespace {{ $namespace }};

use App\Base\Requests\BaseDestroyRequest;

/**
 * Class DestroyRequest
 */
class DestroyRequest extends BaseDestroyRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('{{ $permission }}.destroy');
    }
}
