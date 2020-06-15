<?php 

declare( strict_types = 1 );

namespace App\Modules\Feedback\Models;

use Illuminate\Database\Eloquent\Model;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Feedback extends Model
{
    use Cacheable, Logable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'feedback';
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [ 
        'name',   
        'email',   
        'phone',   
        'message',   
        'created_at',   
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