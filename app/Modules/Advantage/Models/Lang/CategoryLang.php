<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Models\Lang;

use Illuminate\Database\Eloquent\Model;

class CategoryLang extends Model
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
    protected $table = 'advantage_categories_lang';

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
