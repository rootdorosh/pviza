<?php

namespace App\Base\Requests;
 
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class BaseFrontRequest
 * @package App\Http\Requests
 */
class BaseFrontRequest extends BaseRequest
{
    /**
     * Get the failed validation response for the request.
     *
     * @param   Validator $validator
     * @return  HttpResponseException
     */
    protected function failedValidation(Validator $validator) : HttpResponseException
    {
        throw new HttpResponseException(
            response()->json([
                'message' => __('validation.the_given_data_was_invalid'),
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
  
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return true;
    }
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $items = [];
        foreach (static::attributes() as $key => $val) {
            $items[$key . '.required'] = t('common.form.errors.required', [
                'attribute' => $val,
            ]);
        }
        
        return $items;
    }        
    
}
