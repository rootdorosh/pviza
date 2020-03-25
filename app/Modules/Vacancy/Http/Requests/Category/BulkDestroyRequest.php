<?php 

namespace App\Modules\Vacancy\Http\Requests\Category;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\Vacancy
 *
 * @bodyParam  ids   array    required ids.
 * @bodyParam  ids.* integer  required Category id.
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
                'exists:vacancy_categories,id',
            ],
        ];
    }
}
