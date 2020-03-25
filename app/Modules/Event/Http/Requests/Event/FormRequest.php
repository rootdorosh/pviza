<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Http\Requests\Event;

use App\Base\Requests\BaseFormRequest;
use App\Modules\Event\Models\Event;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\Event
 *
 * @bodyParam event_id  string required  Event ID
 * @bodyParam content_type  integer required  Content type
 * @bodyParam is_active  integer required  Active
 * @bodyParam from_email  string optional  From email
 * @bodyParam lang[subject]  string required  Subject
 * @bodyParam lang[from_name]  string optional  Subject
 * @bodyParam lang[body]  string required  Body

 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        $action = empty($this->event) ? 'store' : 'update';
        
        return $this->user()->hasPermission('event.event.' . $action);
    }
    
    /**
     * @return  array
     */
    public function rules(): array
    {
        $rules = [
            'event_id' => [
                'required',
                'string',
            ],
            'content_type' => [
                'required',
                'integer',
                'in:' . implode(',', array_flip(Event::CONTENT_TYPES)),
            ],
            'is_active' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'from_email' => [
                'email',
                'nullable',
                'string',
            ],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.subject'] = [
                'required',
                'string',
                'max:255',
            ];
            $rules[$locale.'.from_name'] = [
                'nullable',
                'string',
                'max:255',
            ];
            $rules[$locale.'.body'] = [
                'required',
                'string',
                'max: 10024',
            ];
        }

		return $rules;
	}
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Event', 'Event', true);
    }
}