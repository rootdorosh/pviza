<?php 
use Illuminate\Support\Str;
?>

declare( strict_types = 1 );

namespace {{ $namespace }};

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
        return $this->user()->hasPermission('{{ $permission }}.{{ $action }}');
    }
}
