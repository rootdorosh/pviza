<?php

declare( strict_types = 1 );

namespace App\Modules\Settings\Http\Requests\Settings;

use App\Base\Requests\BaseFormRequest;

/**
 * Class FormRequest
 *
 * @package  App\Modules\Settings
 *
 * @bodyParam key  string required  Key
 * @bodyParam value  string required  Value

 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('settings.settings.index');
    }

    /**
     * @return  array
     */
    public function rules(): array
    {
        $rules = [
            'menu_header_id' => [
                'nullable',
                'exists:menu,id',
            ],
            'menu_footer_id' => [
                'nullable',
                'exists:menu,id',
            ],
            'event_email_from' => [
                'nullable',
                'string',
                'email',
            ],
            'event_name_from' => [
                'nullable',
                'string',
            ],
            'social_facebook' => [
                'nullable',
                'string',
            ],
            'social_instagram' => [
                'nullable',
                'string',
            ],
            'social_twitter' => [
                'nullable',
                'string',
            ],
            'cb_contact_footer' => [
                'nullable',
                'exists:content_blocks,id',
            ],
            'cb_page_contact_header' => [
                'nullable',
                'exists:content_blocks,id',
            ],
            'cb_page_contact_footer' => [
                'nullable',
                'exists:content_blocks,id',
            ],
            'contact_phone' => [
                'nullable',
            ],
            'contact_email' => [
                'nullable',
                'email',
            ],
            'contact_viber' => [
                'nullable',
            ],
            'contact_telegram' => [
                'nullable',
            ],
            'contact_whatsapp' => [
                'nullable',
            ],
        ];


		return $rules;
	}

    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Settings', 'Settings', false);
    }
}
