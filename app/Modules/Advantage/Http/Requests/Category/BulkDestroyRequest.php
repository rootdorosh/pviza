<?php 

namespace App\Modules\Advantage\Http\Requests\Category;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\Advantage
 *
 * @bodyParam  ids   array    required ids.
 * @bodyParam  ids.* integer  required Category id.
 */
class BulkDestroyRequest extends DestroyRequest
{
    /*
     * @return  array
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
                'exists:advantage_categories,id',
            ],
        ];
    }
}
