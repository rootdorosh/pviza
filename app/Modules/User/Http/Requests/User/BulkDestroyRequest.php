<?php

namespace App\Modules\User\Http\Requests\User;

/**
 * Class BulkDestroyRequest
 * 
 * @package App\Modules\User
 *
 * @bodyParam ids   array    required ids.
 * @bodyParam ids.* integer  required user id.
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
                'exists:users,id',
            ],
        ];
    }
}
