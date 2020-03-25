<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Http\Requests\ContentBlock\Photo;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\ContentBlock\Models\ContentBlock;
use App\Modules\ContentBlock\Models\ContentBlock\Photo;

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
 * @bodyParam  is_active    integer  optional  Active 
 * @bodyParam  rank    integer  optional  Rank 
 * @bodyParam  title    string  optional  Title 
 * @bodyParam  description    string  optional  Description
 */

 class IndexRequest extends BaseIndexRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('contentblock.contentblock.photo.index');
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
					'description'
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
            'is_active' => [
                'nullable',
                'integer',
                'in:0,1',
            ],
            'type' => [
                'nullable',
                'integer',
            ],
            'rank' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'title' => [
                'nullable',
                'max:255',
            ],
            'description' => [
                'nullable',
                'max:1024',
            ],

        ];
    }
        
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('ContentBlock', 'ContentBlockPhoto') + parent::attributes();
    }
    
    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
		$query = Photo::select([
			'content_blocks_photos.*',
			'content_blocks_photos_lang.title AS title',
			'content_blocks_photos_lang.description AS description'
		])
			->leftJoin('content_blocks_photos_lang', 'content_blocks_photos_lang.photo_id', 'content_blocks_photos.id');

		$query->where('content_blocks_photos_lang.locale', app()->getLocale());


        if ($this->id !== null) {
            $query->where("content_blocks_photos.id", "like", "%{$this->id}%");
        }

        if ($this->is_active !== null) {
            $query->where("content_blocks_photos.is_active", "like", "%{$this->is_active}%");
        }

        if ($this->rank !== null) {
            $query->where("content_blocks_photos.rank", "like", "%{$this->rank}%");
        }

        if ($this->title !== null) {
            $query->where("content_blocks_photos_lang.title", "like", "%{$this->title}%");
        }

        if ($this->description !== null) {
            $query->where("content_blocks_photos_lang.description", "like", "%{$this->description}%");
        }
    
        return $query;
    }

}