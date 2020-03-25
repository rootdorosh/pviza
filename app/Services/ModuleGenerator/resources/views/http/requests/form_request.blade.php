<?php 
use Illuminate\Support\Str;
?>declare( strict_types = 1 );

namespace {{ $namespace }};

use App\Base\Requests\BaseFormRequest;@foreach ($uses as $use) 
use {{ $use }};@endforeach


/**
 * Class FormRequest
 * 
 * @package App\Modules\{{ $moduleName }}
 *
{{ $paramsForApi }}
 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        $action = empty($this->{{ Str::snake($modelName) }}) ? 'store' : 'update';
        
        return $this->user()->hasPermission('{{ $permission }}.' . $action);
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
<?= $rules . "\n\t"?>}
    
    /*
     * @return array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('{{ $moduleName }}', '{{ $modelDotName }}', <?php if (!empty($model['translatable'])):?>true<?php else:?>false<?php endif;?>);
    }
}