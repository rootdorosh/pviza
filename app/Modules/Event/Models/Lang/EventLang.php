<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Models\Lang;

use Illuminate\Database\Eloquent\Model;

class EventLang extends Model
{
    /**
     * primary key.
     *
     * @var  string
     */
    protected $primaryKey = 'translation_id';
       
    /**
     * table name.
     *
     * @var  string
     */
    protected $table = 'event_lang';

    /**
     * @var  bool
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'subject',
        'from_name',
        'body', 
    ];
}
