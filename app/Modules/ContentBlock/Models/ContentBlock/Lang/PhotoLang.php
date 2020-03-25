<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Models\ContentBlock\Lang;

use Illuminate\Database\Eloquent\Model;

class PhotoLang extends Model
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
    protected $table = 'content_blocks_photos_lang';

    /**
     * @var  bool
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'title',
        'description', 
    ];
}
