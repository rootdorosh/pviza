<?php 

declare( strict_types = 1 );

namespace App\Modules\Blog\Http\Requests\Blog;

use App\Base\Requests\BaseFormRequest; 
use App\Validators\ImageBase64;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\Blog
 *
 * @bodyParam category_id  integer required  Категорія
 * @bodyParam is_active  integer required  Активність
 * @bodyParam is_home  integer required  На головну
 * @bodyParam image  image optional  Зображення
 * @bodyParam image_header  image optional  Зображення в хедері
 * @bodyParam created_at  datetime required  Дата створення
 * @bodyParam lang[title]  string required  Заголовок
 * @bodyParam lang[alias]  string optional  Alias
 * @bodyParam lang[description]  string optional  Опис
 * @bodyParam lang[seo_h1]  string optional  seo h1
 * @bodyParam lang[seo_title]  string optional  meta title
 * @bodyParam lang[seo_description]  string optional  meta description

 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        $action = empty($this->blog) ? 'store' : 'update';
        
        return $this->user()->hasPermission('blog.blog.' . $action);
    }
    
    /**
     * @return  array
     */
    public function rules(): array
    {
        $rules = [
            'category_id' => [
                'required',
                'integer',
                'exists:blog_categories,id',
            ],
            'is_active' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'is_home' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'image.content' => [
                'nullable',
                'string',
                new ImageBase64(),
            ],
            'image' => [
                'nullable',
            ],
            'image.name' => [
                'nullable',
                'string',
            ],
            'image_header.content' => [
                'nullable',
                'string',
                new ImageBase64(),
            ],
            'image_header' => [
                'nullable',
            ],
            'image_header.name' => [
                'nullable',
                'string',
            ],
            'created_at' => [
                'required',
                'date_format:Y-m-d\TH:i:s.0000',
            ],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.title'] = [
                'required',
                'string',
                'max:255',
            ];
            $rules[$locale.'.alias'] = [
                'nullable',
                'string',
                'max:255',
            ];
            $rules[$locale.'.description'] = [
                'nullable',
                'string',
                'max: 10240',
            ];
            $rules[$locale.'.seo_h1'] = [
                'nullable',
                'string',
                'max: 255',
            ];
            $rules[$locale.'.seo_title'] = [
                'nullable',
                'string',
                'max: 255',
            ];
            $rules[$locale.'.seo_description'] = [
                'nullable',
                'string',
                'max: 255',
            ];
        }

		return $rules;
	}
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Blog', 'Blog', true);
    }
}