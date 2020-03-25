<?php 

namespace App\Modules\Vacancy\Http\Requests\Location;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\Vacancy
 *
 * @bodyParam  ids   array    required ids.
 * @bodyParam  ids.* integer  required Location id.
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
                'exists:vacancy_locations,id',
            ],
        ];
    }
}
