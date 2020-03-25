<?php 

declare( strict_types = 1 );

namespace App\Modules\Translation\Http\Requests\Translation;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Translation\Models\Translation;

/**
 * Class IndexRequest
 * 
 * @package  App\Modules\Translation
 * 
 * @bodyParam  page    integer  optional  page 
 * @bodyParam  per_page    integer  optional  per page 
 * @bodyParam  sort_dir    string  optional  sorting dir 
 * @bodyParam  sort_attr    string  optional  sorting attribute 
 * @bodyParam  id    integer  optional  id 
 * @bodyParam  slug    string  optional  Slug 
 * @bodyParam  value    string  optional  Value
 */

 class IndexRequest extends BaseIndexRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('translation.translation.index');
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
					'slug',
					'value'
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
            ],
            'slug' => [
                'nullable',
                'max:255',
            ],
            'value' => [
                'nullable',
                'max:255',
            ],

        ];
    }
        
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Translation', 'Translation') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
		$query = Translation::select([
			'translations.*',
			'translations_lang.value AS value'
		])
			->leftJoin('translations_lang', 'translations_lang.trans_id', 'translations.id');

		$query->where('translations_lang.locale', app()->getLocale());


        if ($this->id !== null) {
            $query->where("translations.id", "like", "%{$this->id}%");
        }

        if ($this->slug !== null) {
            $query->where("translations.slug", "like", "%{$this->slug}%");
        }

        if ($this->value !== null) {
            $query->where("translations_lang.value", "like", "%{$this->value}%");
        }
    
        return $query;
    }

}