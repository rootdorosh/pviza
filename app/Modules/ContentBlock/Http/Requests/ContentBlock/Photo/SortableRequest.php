<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Http\Requests\ContentBlock\Photo;

use App\Base\Requests\BaseRequest;

/**
 * Class SortableRequest
 * 
 * @bodyParam  ids   array    required ids.
 * @bodyParam  ids.* integer  required ContentBlockPhoto id. 
 */
class SortableRequest extends BaseRequest
{
    /*
     * @return    bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('contentblock.contentblock.photo.update');
    }

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
                'exists:content_blocks_photos,id',
            ],
        ];
    }
}
