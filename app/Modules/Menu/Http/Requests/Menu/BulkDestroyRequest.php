<?php

namespace App\Modules\Menu\Http\Requests\Menu;

/**
 * Class BulkDestroyRequest
 * 
 * @package App\Modules\Menu
 *
 * @bodyParam ids   array    required ids.
 * @bodyParam ids.* integer  required menu id.
 */
class BulkDestroyRequest extends DestroyRequest
{
    /*
     * @return array
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
                'exists:menu,id',
            ],
        ];
    }
}
