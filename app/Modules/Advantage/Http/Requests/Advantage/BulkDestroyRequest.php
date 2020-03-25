<?php 

namespace App\Modules\Advantage\Http\Requests\Advantage;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\Advantage
 *
 * @bodyParam  ids   array    required ids.
 * @bodyParam  ids.* integer  required Advantage id.
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
                'exists:advantage,id',
            ],
        ];
    }
}
