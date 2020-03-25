<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\Image\Thumbnailable;
use App\Services\Translatable\Translatable;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class ContentBlock extends Model
{
    use Thumbnailable, Translatable, Cacheable, Logable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'content_blocks';
    
    /**
     * @var  string
     */
	public $translationForeignKey = 'content_block_id';	

    /*
     * @var  array
     */
    public $translatedAttributes = [
        'title',
        'body', 
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
        'name',
        'is_active',
        'is_hide_editor',
        'adaptive_image', 
    ];  
  
    /**
     * Get the photos.
     *
     * @return  HasMany
     */
    public function photos() : HasMany
    {
        return $this->hasMany('App\Modules\ContentBlock\Models\ContentBlock\Photo');
    }
    
}