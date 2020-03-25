<?php 

declare( strict_types = 1 );

namespace App\Modules\Translation\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Translatable\Translatable;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Translation extends Model
{
    use Translatable, Cacheable, Logable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'translations';
    
    /**
     * @var  string
     */
	public $translationForeignKey = 'trans_id';	

    /*
     * @var  array
     */
    public $translatedAttributes = [
        'value', 
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
        'slug', 
    ];  
    
}