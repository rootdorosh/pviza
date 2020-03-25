<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Queue extends Model
{
    use Cacheable, Logable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

	CONST STATUS_AWAIT = 1;
	CONST STATUS_SEND = 2;
	CONST STATUS_FAIL = 3;
	CONST STATUSES = [
		self::STATUS_AWAIT => 'await',
		self::STATUS_SEND => 'send',
		self::STATUS_FAIL => 'fail',
	];
    
    /*
     * @var  string
     */
    public $table = 'event_queue';
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'event_id',
        'status',
        'from_email',
        'from_name',
        'email_to',
        'subject',
        'body',
        'created_time',
        'sended_time',
        'files', 
    ];  
    
    /*
     * @return string|null
     */
    public function getStatusTitle():? string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
    
}