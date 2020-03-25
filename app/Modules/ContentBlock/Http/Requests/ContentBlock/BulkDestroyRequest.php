<?php 

namespace App\Modules\ContentBlock\Http\Requests\ContentBlock;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\ContentBlock
 *
 * @bodyParam  ids   array    required ids.
 * @bodyParam  ids.* integer  required ContentBlock id.
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
                'exists:content_blocks,id',
            ],
        ];
    }
}
