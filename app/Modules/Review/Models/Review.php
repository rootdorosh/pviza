<?php 

declare( strict_types = 1 );

namespace App\Modules\Review\Models;

use Illuminate\Database\Eloquent\Model;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Review extends Model
{
    use Cacheable, Logable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'review';
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [ 
        'is_active',   
        'is_home',   
        'created_at',   
        'name',   
        'email',   
        'comment',   
    ];  

	/**
	* Set attribute created_at.
	*/
	public function setCreatedAtAttribute($value)
	{
		if (!is_int($value)) {
			$value = strtotime($value);
		}
		$this->attributes['created_at'] = $value;
	}

}