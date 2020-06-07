<?php 

declare( strict_types = 1 );

namespace App\Modules\Review\Http\Requests\Review;

use App\Base\Requests\BaseFormRequest;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\Review
 *
 * @bodyParam is_active  integer required  Активність
 * @bodyParam is_home  integer required  На головну
 * @bodyParam created_at  datetime required  Дата створення
 * @bodyParam name  string required  Имя
 * @bodyParam email  string required  E-mail
 * @bodyParam comment  string required  Коментар

 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        $action = empty($this->review) ? 'store' : 'update';
        
        return $this->user()->hasPermission('review.review.' . $action);
    }
    
    /**
     * @return  array
     */
    public function rules(): array
    {
        $rules = [
            'is_active' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'is_home' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'created_at' => [
                'required',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
            ],
            'comment' => [
                'required',
                'string',
            ],
        ];


		return $rules;
	}
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Review', 'Review', false);
    }
}