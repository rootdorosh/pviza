<?php 

declare( strict_types = 1 );

namespace App\Modules\Feedback\Http\Requests\Feedback;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Feedback\Models\Feedback;

/**
 * Class IndexRequest
 * 
 * @package  App\Modules\Feedback
 * 
 * @bodyParam  page    integer  optional  page 
 * @bodyParam  per_page    integer  optional  per page 
 * @bodyParam  sort_dir    string  optional  sorting dir 
 * @bodyParam  sort_attr    string  optional  sorting attribute 
 * @bodyParam  id    integer  optional  id 
 * @bodyParam  name    string  optional  Name 
 * @bodyParam  email    string  optional  Email 
 * @bodyParam  phone    string  optional  Phone 
 * @bodyParam  created_at    datetime  optional  Created at
 */

 class IndexRequest extends BaseIndexRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('feedback.feedback.index');
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
					'name',
					'email',
					'phone',
					'created_at'
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
            ],
            'name' => [
                'nullable',
                'max:255',
            ],
            'email' => [
                'nullable',
                'max:255',
            ],
            'phone' => [
                'nullable',
                'max:255',
            ],
            'message' => [
                'nullable',
                'max:1024',
            ],
            'created_at' => [
                'nullable',
            ],

        ];
    }
        
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Feedback', 'Feedback') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
		$query = Feedback::select([
			'feedback.*'
		])
			;


        if ($this->id !== null) {
            $query->where("feedback.id", "like", "%{$this->id}%");
        }

        if ($this->name !== null) {
            $query->where("feedback.name", "like", "%{$this->name}%");
        }

        if ($this->email !== null) {
            $query->where("feedback.email", "like", "%{$this->email}%");
        }

        if ($this->phone !== null) {
            $query->where("feedback.phone", "like", "%{$this->phone}%");
        }

        if ($this->created_at !== null) {
            $query->where("feedback.created_at", "like", "%{$this->created_at}%");
        }
    
        return $query;
    }

}