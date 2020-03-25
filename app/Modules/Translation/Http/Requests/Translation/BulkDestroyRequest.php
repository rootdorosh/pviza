<?php 

namespace App\Modules\Translation\Http\Requests\Translation;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\Translation
 *
 * @bodyParam  ids   array    required ids.
 * @bodyParam  ids.* integer  required Translation id.
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
                'exists:translations,id',
            ],
        ];
    }
}
