<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Http\Requests\ContentBlock;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\ContentBlock\Models\ContentBlock;

/**
 * Class IndexRequest
 * 
 * @package  App\Modules\ContentBlock
 * 
 * @bodyParam  page    integer  optional  page 
 * @bodyParam  per_page    integer  optional  per page 
 * @bodyParam  sort_dir    string  optional  sorting dir 
 * @bodyParam  sort_attr    string  optional  sorting attribute 
 * @bodyParam  id    integer  optional  id 
 * @bodyParam  name    string  optional  Name 
 * @bodyParam  is_active    integer  optional  Active 
 * @bodyParam  is_hide_editor    integer  optional  Hide editor 
 * @bodyParam  title    string  optional  Title
 */

 class IndexRequest extends BaseIndexRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('contentblock.contentblock.index');
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
					'is_active',
					'is_hide_editor',
					'title'
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
            ],
            'image_base64' => [
                'nullable',
            ],
            'image_name' => [
                'nullable',
                'string',
            ],
            'name' => [
                'nullable',
                'max:255',
            ],
            'is_active' => [
                'nullable',
                'integer',
                'in:0,1',
            ],
            'is_hide_editor' => [
                'nullable',
                'integer',
                'in:0,1',
            ],
            'adaptive_image' => [
                'nullable',
            ],
            'title' => [
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
        return $this->getAttributesLabels('ContentBlock', 'ContentBlock') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
		$query = ContentBlock::select([
			'content_blocks.*',
			'content_blocks_lang.title AS title'
		])
			->leftJoin('content_blocks_lang', 'content_blocks_lang.content_block_id', 'content_blocks.id');

		$query->where('content_blocks_lang.locale', app()->getLocale());


        if ($this->id !== null) {
            $query->where("content_blocks.id", "like", "%{$this->id}%");
        }

        if ($this->name !== null) {
            $query->where("content_blocks.name", "like", "%{$this->name}%");
        }

        if ($this->is_active !== null) {
            $query->where("content_blocks.is_active", "like", "%{$this->is_active}%");
        }

        if ($this->is_hide_editor !== null) {
            $query->where("content_blocks.is_hide_editor", "like", "%{$this->is_hide_editor}%");
        }

        if ($this->title !== null) {
            $query->where("content_blocks_lang.title", "like", "%{$this->title}%");
        }
    
        return $query;
    }

}