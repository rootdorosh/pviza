<?php

namespace App\Base\Requests;
 
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Exceptions\RouteParamValidationException;

/**
 * Class BaseFormRequest
 * @package App\Http\Requests
 */
abstract class BaseFormRequest extends BaseRequest
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

    /**
     * Get the failed validation route params.
     *
     * @param   array $errors
     * @return  void
     * @throw   RouteParamValidationException
     */
    protected function failedValidationRouteParams(array $errors) : void
    {
        $validator = $this->getValidatorInstance();
        foreach ($errors as $field => $message) {
            $validator->errors()->add($field, $message);
        }
        
        throw (new RouteParamValidationException($validator));
    }
}
