<?php 

namespace App\Modules\Blog\Http\Requests\Blog;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\Blog
 *
 * @bodyParam  ids   array    required ids.
 * @bodyParam  ids.* integer  required Blog id.
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
                'exists:blog,id',
            ],
        ];
    }
}
