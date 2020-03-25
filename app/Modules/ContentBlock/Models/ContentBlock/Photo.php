<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Models\ContentBlock;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\Image\Thumbnailable;
use App\Services\Translatable\Translatable;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Photo extends Model
{
    use Thumbnailable, Translatable, Cacheable, Logable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

	CONST TYPE_IMAGE = 1;
	CONST TYPE_MAP = 2;
	CONST TYPE_PLAN = 3;
	CONST TYPES = [
		self::TYPE_IMAGE => 'image',
		self::TYPE_MAP => 'map',
		self::TYPE_PLAN => 'plan',
	];

    /*
     * @var  string
     */
    public $table = 'content_blocks_photos';
    
    /**
     * @var  string
     */
	public $translationForeignKey = 'photo_id';	

    /*
     * @var  array
     */
    public $translatedAttributes = [
        'title',
        'description', 
    ];

    /*
     * @var  array
     */
    protected $with = ['translations'];
        
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'image',
        'is_active',
        'type',
        'rank', 
    ];  
  
    /**
     * Get the contentBlock.
     *
     * @return  BelongsTo
     */
    public function contentBlock() : BelongsTo
    {
        return $this->belongsTo('App\Modules\ContentBlock\Models\ContentBlock\Photo');
    }
    
}