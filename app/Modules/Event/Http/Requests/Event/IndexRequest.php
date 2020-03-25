<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Http\Requests\Event;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Event\Models\Event;

/**
 * Class IndexRequest
 * 
 * @package  App\Modules\Event
 * 
 * @bodyParam  page    integer  optional  page 
 * @bodyParam  per_page    integer  optional  per page 
 * @bodyParam  sort_dir    string  optional  sorting dir 
 * @bodyParam  sort_attr    string  optional  sorting attribute 
 * @bodyParam  id    integer  optional  id 
 * @bodyParam  is_active    integer  optional  Active 
 * @bodyParam  from_email    string  optional  From email 
 * @bodyParam  subject    string  optional  Subject 
 * @bodyParam  from_name    string  optional  Subject
 */

 class IndexRequest extends BaseIndexRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('event.event.index');
    }
    
    /*
     * @return  array
     */
    public function rules(): array
    {
        return parent::rules() + [
            'sort_attr' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    'id',
					'is_active',
					'from_email',
					'subject',
					'from_name'
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
            ],
            'event_id' => [
                'nullable',
            ],
            'content_type' => [
                'nullable',
                'integer',
                'in:' . implode(',', array_flip(Event::CONTENT_TYPES)),
            ],
            'is_active' => [
                'nullable',
                'integer',
                'in:0,1',
            ],
            'from_email' => [
                'nullable',
            ],
            'subject' => [
                'nullable',
                'max:255',
            ],
            'from_name' => [
                'nullable',
                'max:255',
            ],
            'body' => [
                'nullable',
                'max: 10024',
            ],

        ];
    }
        
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Event', 'Event') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
		$query = Event::select([
			'event.*',
			'event_lang.subject AS subject',
			'event_lang.from_name AS from_name'
		])
			->leftJoin('event_lang', 'event_lang.event_id', 'event.id');

		$query->where('event_lang.locale', app()->getLocale());


        if ($this->id !== null) {
            $query->where("event.id", "like", "%{$this->id}%");
        }

        if ($this->is_active !== null) {
            $query->where("event.is_active", "like", "%{$this->is_active}%");
        }

        if ($this->from_email !== null) {
            $query->where("event.from_email", "like", "%{$this->from_email}%");
        }

        if ($this->subject !== null) {
            $query->where("event_lang.subject", "like", "%{$this->subject}%");
        }

        if ($this->from_name !== null) {
            $query->where("event_lang.from_name", "like", "%{$this->from_name}%");
        }
    
        return $query;
    }

}