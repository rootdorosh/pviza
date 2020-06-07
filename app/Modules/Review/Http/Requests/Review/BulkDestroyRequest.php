<?php 

namespace App\Modules\Review\Http\Requests\Review;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\Review
 *
 * @bodyParam  ids   array    required ids.
 * @bodyParam  ids.* integer  required Review id.
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
                'exists:review,id',
            ],
        ];
    }
}
