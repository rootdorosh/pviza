<?php

declare( strict_types = 1 );

namespace App\Modules\Review\Front\Http\Requests\Review;

use App\Base\Requests\BaseFrontRequest;

/**
 * Class FormRequest
 *
 * @package  App\Modules\Review
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
        $items = t_array('required.form.fields.');

        return $items;
    }

}
