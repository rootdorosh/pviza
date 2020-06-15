<?php

declare( strict_types = 1 );

namespace App\Modules\Feedback\Front\Http\Requests\Feedback;

use App\Base\Requests\BaseFrontRequest;
use App\Validators\Phone as PhoneRule;

/**
 * Class FormRequest
 *
 * @package  App\Modules\Feedback
 *
 */
class FormRequest extends BaseFrontRequest
{
    /**
     * @return  array
     */
    public function rules(): array
    {
		$rules = [
            'name' => [
                'required',
                'string',
            ],
            'email' => [
                'nullable',
                'string',
                'email',
            ],
            'phone' => [
                'required',
                'string',
            ],
            'message' => [
                'required',
                'string',
            ],
        ];

        return $rules;
	}

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return array_merge(parent::messages(), [
            'email.email' => t('common.form.errors.email.format'),
        ]);
    }

    /*
     * @return  array
     */
    public function attributes(): array
    {
        return t_array('feedback.form.fields.');
    }

}
