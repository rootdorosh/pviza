<?php 

declare( strict_types = 1 );

namespace App\Modules\Resume\Http\Requests\Resume;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Resume\Models\Resume;

/**
 * Class IndexRequest
 * 
 * @package  App\Modules\Resume
 * 
 * @bodyParam  page    integer  optional  page 
 * @bodyParam  per_page    integer  optional  per page 
 * @bodyParam  sort_dir    string  optional  sorting dir 
 * @bodyParam  sort_attr    string  optional  sorting attribute 
 * @bodyParam  id    integer  optional  id 
 * @bodyParam  vacancy_title    string  optional  Vacancy 
 * @bodyParam  created_at    datetime  optional  Created at 
 * @bodyParam  name    string  optional  Name 
 * @bodyParam  email    string  optional  Email 
 * @bodyParam  phone    string  optional  Phone
 */

 class IndexRequest extends BaseIndexRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('resume.resume.index');
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
					'vacancy_title',
					'created_at',
					'name',
					'email',
					'phone'
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
            ],
            'vacancy_title' => [
                'nullable',
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
            'document' => [
                'nullable',
            ],

        ];
    }
        
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Resume', 'Resume') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
		$query = Resume::select([
			'resume.*',
			'vacancy_lang.title AS vacancy_title'
		])
			->leftJoin('vacancy', 'vacancy.id', 'resume.vacancy_id')
			->leftJoin('vacancy_lang', 'vacancy_lang.vacancy_id', 'vacancy.id');

		$query->where('vacancy_lang.locale', app()->getLocale());


        if ($this->id !== null) {
            $query->where("resume.id", "like", "%{$this->id}%");
        }

        if ($this->vacancy_title !== null) {
            $query->where("vacancy.id" , $this->vacancy_title);
        }

        if ($this->created_at !== null) {
            $query->where("resume.created_at", "like", "%{$this->created_at}%");
        }

        if ($this->name !== null) {
            $query->where("resume.name", "like", "%{$this->name}%");
        }

        if ($this->email !== null) {
            $query->where("resume.email", "like", "%{$this->email}%");
        }

        if ($this->phone !== null) {
            $query->where("resume.phone", "like", "%{$this->phone}%");
        }
    
        return $query;
    }

}