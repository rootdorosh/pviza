<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;    
use App\Services\Image\Thumbnailable;
use App\Services\Translatable\Translatable;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Vacancy extends Model
{
    use Thumbnailable, Translatable, Cacheable, Logable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'vacancy';
    
    /**
     * @var  string
     */
	public $translationForeignKey = 'vacancy_id';	

    /*
     * @var  array
     */
    public $translatedAttributes = [
        'title',
        'alias',
        'salary',
        'work_schedule',
        'contract_type',
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
        'is_popular',   
        'rank',   
        'date_posted',   
        'hiring_organization',   
        'image',   
    ];  
  
    /**
     * Get the categories.
     *
     * @return  BelongsToMany
     */
    public function categories() : BelongsToMany
    {    
        return $this->belongsToMany('App\Modules\Vacancy\Models\Category', 'vacancy_vs_category');
	}
  
    /**
     * Get the types.
     *
     * @return  BelongsToMany
     */
    public function types() : BelongsToMany
    {    
        return $this->belongsToMany('App\Modules\Vacancy\Models\Type', 'vacancy_vs_type');
	}
  
    /**
     * Get the locations.
     *
     * @return  BelongsToMany
     */
    public function locations() : BelongsToMany
    {    
        return $this->belongsToMany('App\Modules\Vacancy\Models\Location', 'vacancy_vs_location');
	}
    
}