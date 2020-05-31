<?php 

declare( strict_types = 1 );

namespace App\Modules\Resume\Front\Http\Requests\Resume;

use App\Base\Requests\BaseFrontRequest;
use App\Validators\Phone as PhoneRule;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\Resume
 *
 */
class FormRequest extends BaseFrontRequest
{
    const MIMES = 'jpg,jpeg,png,gif,rtf,txt,doc,docx';
    
    /**
     * @return  array
     */
    public function rules(): array
    {
		$rules = [
            'vacancy_id' => [
                'required',
                'integer',
            ],
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
                'nullable',
                'string',
            ],
            'file' => [
                'nullable',
                'mimes:' . self::MIMES,
                'max:' . 5 * 1024,
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
            'files.*.mimes' => t('common.form.errors.files.mimes', [
                'attribute' => $this->attributes()['file'],
                'mimes' => self::MIMES,
            ]),
        ]);
    }    
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        $items = t_array('resume.form.fields.');
        $items['files.*'] = $items['file'];
        
        return $items;
    }
    
}