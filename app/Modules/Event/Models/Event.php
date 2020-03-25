<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Services\Translatable\Translatable;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Event extends Model
{
    use Translatable, Cacheable, Logable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

	CONST CONTENT_TYPE_TEXT_PLAIN = 1;
	CONST CONTENT_TYPE_TEXT_HTML = 2;
	CONST CONTENT_TYPES = [
		self::CONTENT_TYPE_TEXT_PLAIN => 'text/plain',
		self::CONTENT_TYPE_TEXT_HTML => 'text/html',
	];

    /*
     * @var  string
     */
    public $table = 'event';
    
    /**
     * @var  string
     */
	public $translationForeignKey = 'event_id';	

    /*
     * @var  array
     */
    public $translatedAttributes = [
        'subject',
        'from_name',
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
        'event_id',
        'content_type',
        'is_active',
        'from_email', 
    ];  
    
    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            'App\Modules\User\Models\User',
            'users_vs_events'
        )->where('is_active', 1);
    }
    
}