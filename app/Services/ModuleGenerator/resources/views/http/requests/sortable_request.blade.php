<?php 
use Illuminate\Support\Str;
?>

declare( strict_types = 1 );

namespace {{ $namespace }};

use App\Base\Requests\BaseRequest;

/**
 * Class SortableRequest
 * 
 * @bodyParam ids   array    required ids.
 * @bodyParam ids.* integer  required {{ $modelName }} id. 
 */
class SortableRequest extends BaseRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('{{ $permission }}.update');
    }

    /*
     * @return array
     */
    public function rules(): array
    {
        return [
            'ids'   => [
                'required',
                'array',
            ],
            'ids.*' => [
                'required',
                'integer',
                'exists:{{ $model['table'] }},id',
            ],
        ];
    }
}
