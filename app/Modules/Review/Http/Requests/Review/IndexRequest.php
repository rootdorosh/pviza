<?php 

declare( strict_types = 1 );

namespace App\Modules\Review\Http\Requests\Review;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Review\Models\Review;

/**
 * Class IndexRequest
 * 
 * @package  App\Modules\Review
 * 
 * @bodyParam  page    integer  optional  page 
 * @bodyParam  per_page    integer  optional  per page 
 * @bodyParam  sort_dir    string  optional  sorting dir 
 * @bodyParam  sort_attr    string  optional  sorting attribute 
 * @bodyParam  id    integer  optional  id 
 * @bodyParam  is_active    integer  optional  Активність 
 * @bodyParam  is_home    integer  optional  На головну 
 * @bodyParam  created_at    datetime  optional  Дата створення 
 * @bodyParam  name    string  optional  Имя 
 * @bodyParam  email    string  optional  E-mail 
 * @bodyParam  comment    string  optional  Коментар
 */

 class IndexRequest extends BaseIndexRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('review.review.index');
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
					'is_home',
					'created_at',
					'name',
					'email',
					'comment'
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
            ],
            'is_active' => [
                'nullable',
                'integer',
                'in:0,1',
            ],
            'is_home' => [
                'nullable',
                'integer',
                'in:0,1',
            ],
            'created_at' => [
                'nullable',
            ],
            'name' => [
                'nullable',
                'max:255',
            ],
            'email' => [
                'nullable',
                'email',
            ],
            'comment' => [
                'nullable',
            ],

        ];
    }
        
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Review', 'Review') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
		$query = Review::select([
			'review.*'
		])
			;


        if ($this->id !== null) {
            $query->where("review.id", "like", "%{$this->id}%");
        }

        if ($this->is_active !== null) {
            $query->where("review.is_active", "like", "%{$this->is_active}%");
        }

        if ($this->is_home !== null) {
            $query->where("review.is_home", "like", "%{$this->is_home}%");
        }

        if ($this->created_at !== null) {
            $query->where("review.created_at", "like", "%{$this->created_at}%");
        }

        if ($this->name !== null) {
            $query->where("review.name", "like", "%{$this->name}%");
        }

        if ($this->email !== null) {
            $query->where("review.email", "like", "%{$this->email}%");
        }

        if ($this->comment !== null) {
            $query->where("review.comment", "like", "%{$this->comment}%");
        }
    
        return $query;
    }

}