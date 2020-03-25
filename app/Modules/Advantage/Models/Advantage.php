<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\Image\Thumbnailable;
use App\Services\Translatable\Translatable;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Advantage extends Model
{
    use Thumbnailable, Translatable, Cacheable, Logable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'advantage';
    
    /**
     * @var  string
     */
	public $translationForeignKey = 'advantage_id';	

    /*
     * @var  array
     */
    public $translatedAttributes = [
        'title',
        'description',
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
        'category_id',
        'image',
        'is_active',
        'rank',
        'svg_code', 
    ];  
  
    /**
     * Get the category.
     *
     * @return  BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo('App\Modules\Advantage\Models\Category');
    }
   
   
   
   
     
}