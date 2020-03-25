<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Image\Thumbnailable;
use App\Services\Translatable\Translatable;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Category extends Model
{
    use Thumbnailable, Translatable, Cacheable, Logable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'vacancy_categories';
    
    /**
     * @var  string
     */
	public $translationForeignKey = 'category_id';	

    /*
     * @var  array
     */
    public $translatedAttributes = [
        'title',
        'alias',
        'description',
        'seo_h1',
        'seo_title',
        'seo_description', 
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
        'image',   
    ];  
    
}