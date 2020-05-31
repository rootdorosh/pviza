<?php 

namespace App\Modules\Resume\Http\Requests\Resume;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\Resume
 *
 * @bodyParam  ids   array    required ids.
 * @bodyParam  ids.* integer  required Resume id.
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
                'exists:resume,id',
            ],
        ];
    }
}
