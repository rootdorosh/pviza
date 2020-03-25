<?php 

namespace App\Modules\Event\Http\Requests\Event;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\Event
 *
 * @bodyParam  ids   array    required ids.
 * @bodyParam  ids.* integer  required Event id.
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
                'exists:event,id',
            ],
        ];
    }
}
