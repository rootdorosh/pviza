namespace {{ $namespace }};

/**
 * Class BulkDestroyRequest
 * 
 * @package App\Modules\{{ $moduleName }}
 *
 * @bodyParam ids   array    required ids.
 * @bodyParam ids.* integer  required {{ $modelName }} id.
 */
class BulkDestroyRequest extends DestroyRequest
{
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
