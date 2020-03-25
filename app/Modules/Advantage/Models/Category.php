<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Translatable\Translatable;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Category extends Model
{
    use Translatable, Cacheable, Logable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'advantage_categories';
    
    /**
     * @var  string
     */
	public $translationForeignKey = 'category_id';	

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
        'is_active',
        'rank', 
    ];  
  
   
     
}