<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Http\Requests\Queue;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Event\Models\Queue;

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
 * @bodyParam  event_subject    string  optional  Event 
 * @bodyParam  from_email    string  optional  From email 
 * @bodyParam  from_name    string  optional  From name 
 * @bodyParam  email_to    string  optional  Email to 
 * @bodyParam  subject    string  optional  Subject 
 * @bodyParam  body    string  optional  Body 
 * @bodyParam  created_time    integer  optional  Created time 
 * @bodyParam  sended_time    integer  optional  Sended time
 */

 class IndexRequest extends BaseIndexRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('event.queue.index');
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
					'event_subject',
					'from_email',
					'from_name',
					'email_to',
					'subject',
					'body',
					'status',
					'created_time',
					'sended_time'
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
            ],
            'event_subject' => [
                'nullable',
            ],
            'status' => [
                'nullable',
                'integer',
                'in:' . implode(',', array_flip(Queue::STATUSES)),
            ],
            'from_email' => [
                'nullable',
                'max:255',
            ],
            'from_name' => [
                'nullable',
                'max:255',
            ],
            'email_to' => [
                'nullable',
                'max:255',
            ],
            'subject' => [
                'nullable',
                'max:255',
            ],
            'body' => [
                'nullable',
                'max:10024',
            ],
            'created_time' => [
                'nullable',
                'string',
            ],
            'sended_time' => [
                'nullable',
                'string',
            ],
        ];
    }
        
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Event', 'Queue') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
		$query = Queue::select([
			'event_queue.*',
			'event_lang.subject AS event_subject'
		])
			->leftJoin('event', 'event.id', 'event_queue.event_id')
			->leftJoin('event_lang', 'event_lang.event_id', 'event.id');

		$query->where('event_lang.locale', app()->getLocale());


        if ($this->id !== null) {
            $query->where("event_queue.id", "like", "%{$this->id}%");
        }

        if ($this->status !== null) {
            $query->where("event_queue.status", $this->status);
        }

        if ($this->event_subject !== null) {
            $query->where("event_lang.subject", "like", "%{$this->event_subject}%");
        }

        if ($this->from_email !== null) {
            $query->where("event_queue.from_email", "like", "%{$this->from_email}%");
        }

        if ($this->from_name !== null) {
            $query->where("event_queue.from_name", "like", "%{$this->from_name}%");
        }

        if ($this->email_to !== null) {
            $query->where("event_queue.email_to", "like", "%{$this->email_to}%");
        }

        if ($this->subject !== null) {
            $query->where("event_queue.subject", "like", "%{$this->subject}%");
        }

        if ($this->body !== null) {
            $query->where("event_queue.body", "like", "%{$this->body}%");
        }

        if ($this->created_time !== null) {
            $query->where("event_queue.created_time", "like", "%{$this->created_time}%");
        }

        if ($this->sended_time !== null) {
            $query->where("event_queue.sended_time", "like", "%{$this->sended_time}%");
        }
    
        return $query;
    }

}