<?php 

declare( strict_types = 1 );

namespace App\Modules\Resume\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;    
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Resume extends Model
{
    use Cacheable, Logable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'resume';
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [ 
        'vacancy_id',   
        'created_at',   
        'name',   
        'email',   
        'phone',   
        'message',   
        'document',   
    ];  
  
    /**
     * Get the vacancy.
     *
     * @return  BelongsTo
     */
    public function vacancy() : BelongsTo
    { 
        return $this->belongsTo('App\Modules\Vacancy\Models\Vacancy');
    
	}

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
    
    
    public function getFileUrl():? string
    {
        return $this->document 
            ? config('app.url') . \App\Services\Storage\ImageStorageManager::UPLOAD_PATH . $this->document
            : null;        
    }
}