<?php 

declare( strict_types = 1 );

namespace App\Modules\Blog\Http\Requests\Blog;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Blog\Models\Blog;

/**
 * Class IndexRequest
 * 
 * @package  App\Modules\Blog
 * 
 * @bodyParam  page    integer  optional  page 
 * @bodyParam  per_page    integer  optional  per page 
 * @bodyParam  sort_dir    string  optional  sorting dir 
 * @bodyParam  sort_attr    string  optional  sorting attribute 
 * @bodyParam  id    integer  optional  id 
 * @bodyParam  category_title    string  optional  Категорія 
 * @bodyParam  is_active    integer  optional  Активність 
 * @bodyParam  is_home    integer  optional  На головну 
 * @bodyParam  created_at    datetime  optional  Дата створення 
 * @bodyParam  title    string  optional  Заголовок 
 * @bodyParam  alias    string  optional  Alias
 */

 class IndexRequest extends BaseIndexRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('blog.blog.index');
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
					'category_title',
					'is_active',
					'is_home',
					'created_at',
					'title',
					'alias'
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
            ],
            'category_title' => [
                'nullable',
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
            'image_base64' => [
                'nullable',
            ],
            'image_name' => [
                'nullable',
                'string',
            ],
            'image_header_base64' => [
                'nullable',
            ],
            'image_header_name' => [
                'nullable',
                'string',
            ],
            'created_at' => [
                'nullable',
            ],
            'title' => [
                'nullable',
                'max:255',
            ],
            'alias' => [
                'nullable',
                'max:255',
            ],
            'description' => [
                'nullable',
                'max: 10240',
            ],
            'seo_h1' => [
                'nullable',
                'max: 255',
            ],
            'seo_title' => [
                'nullable',
                'max: 255',
            ],
            'seo_description' => [
                'nullable',
                'max: 255',
            ],

        ];
    }
        
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Blog', 'Blog') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
		$query = Blog::select([
			'blog.*',
			'blog_lang.title AS title',
			'blog_lang.alias AS alias',
			'blog_categories_lang.title AS category_title'
		])
			->leftJoin('blog_lang', 'blog_lang.blog_id', 'blog.id')
			->leftJoin('blog_categories', 'blog_categories.id', 'blog.category_id')
			->leftJoin('blog_categories_lang', 'blog_categories_lang.category_id', 'blog_categories.id');

		$query->where('blog_lang.locale', app()->getLocale())
			->where('blog_categories_lang.locale', app()->getLocale());


        if ($this->id !== null) {
            $query->where("blog.id", "like", "%{$this->id}%");
        }

        if ($this->category_title !== null) {
            $query->where("blog_categories.id" , $this->category_title);
        }

        if ($this->is_active !== null) {
            $query->where("blog.is_active", "like", "%{$this->is_active}%");
        }

        if ($this->is_home !== null) {
            $query->where("blog.is_home", "like", "%{$this->is_home}%");
        }

        if ($this->created_at !== null) {
            $query->where("blog.created_at", "like", "%{$this->created_at}%");
        }

        if ($this->title !== null) {
            $query->where("blog_lang.title", "like", "%{$this->title}%");
        }

        if ($this->alias !== null) {
            $query->where("blog_lang.alias", "like", "%{$this->alias}%");
        }
    
        return $query;
    }

}