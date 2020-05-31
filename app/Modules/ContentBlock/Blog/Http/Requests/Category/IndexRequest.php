<?php 

declare( strict_types = 1 );

namespace App\Modules\Blog\Http\Requests\Category;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Blog\Models\Category;

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
 * @bodyParam  is_active    integer  optional  Активність 
 * @bodyParam  rank    integer  optional  Порядок виводу 
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
        return $this->user()->hasPermission('blog.category.index');
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
					'rank',
					'title',
					'alias'
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
            'rank' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'image_base64' => [
                'nullable',
            ],
            'image_name' => [
                'nullable',
                'string',
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
                'max: 1024',
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
        return $this->getAttributesLabels('Blog', 'Category') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
		$query = Category::select([
			'blog_categories.*',
			'blog_categories_lang.title AS title',
			'blog_categories_lang.alias AS alias'
		])
			->leftJoin('blog_categories_lang', 'blog_categories_lang.category_id', 'blog_categories.id');

		$query->where('blog_categories_lang.locale', app()->getLocale());


        if ($this->id !== null) {
            $query->where("blog_categories.id", "like", "%{$this->id}%");
        }

        if ($this->is_active !== null) {
            $query->where("blog_categories.is_active", "like", "%{$this->is_active}%");
        }

        if ($this->rank !== null) {
            $query->where("blog_categories.rank", "like", "%{$this->rank}%");
        }

        if ($this->title !== null) {
            $query->where("blog_categories_lang.title", "like", "%{$this->title}%");
        }

        if ($this->alias !== null) {
            $query->where("blog_categories_lang.alias", "like", "%{$this->alias}%");
        }
    
        return $query;
    }

}