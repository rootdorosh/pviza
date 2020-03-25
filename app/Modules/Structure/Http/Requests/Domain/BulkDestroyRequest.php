<?php

namespace App\Modules\Structure\Http\Requests\Domain;

/**
 * Class BulkDestroyRequest
 * 
 * @package App\Modules\Structure
 *
 * @bodyParam ids   array    required ids.
 * @bodyParam ids.* integer  required domain id.
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
                'exists:structure_domains,id',
            ],
        ];
    }
}
