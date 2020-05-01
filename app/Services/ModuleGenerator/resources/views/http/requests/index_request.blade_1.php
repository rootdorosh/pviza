<?php 
use Illuminate\Support\Str;
$fields = $model['fields'];
if (!empty($model['translatable'])) {
    $fields = $fields + $model['translatable']['fields'];
}

?>declare( strict_types = 1 );

namespace {{ $namespace }};

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
@foreach ($namespaceModels as $item)use {{ $item }};
@endforeach

/**
 * Class IndexRequest
 * 
 * @package App\Modules\{{ $moduleName }}
 *@foreach ($bodyParams as $item) 
 * @bodyParam {{ $item[0] }}    {{ $item[1] }}  {{ $item[2] }}  {{ $item[3] }}@endforeach<?= "\n"?>
 */

 class IndexRequest extends BaseIndexRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('{{ $permission }}.index');
    }
    
    /*
     * @return array
     */
    public function rules(): array
    {
        return parent::rules() + [
            'sort_attr' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    {!! implode(",\n\t\t\t\t\t", array_map(function($value){ return "'{$value}'"; }, $sortAttrs)); !!}
                ]),
            ],
            {!! $rules !!}
        ];
    }
        
    /*
     * @return array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('{{ $moduleName }}', '{{ $modelName }}') + parent::attributes();
    }
    
    /*
     * @return Builder
     */
    public function getQueryBuilder() : Builder
    {
{!! $query !!}    
        return $query;
    }

}