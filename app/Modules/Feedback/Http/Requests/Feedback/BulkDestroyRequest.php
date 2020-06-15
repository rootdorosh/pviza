<?php 

namespace App\Modules\Feedback\Http\Requests\Feedback;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\Feedback
 *
 * @bodyParam  ids   array    required ids.
 * @bodyParam  ids.* integer  required Feedback id.
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
                'exists:feedback,id',
            ],
        ];
    }
}
