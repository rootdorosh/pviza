<?php

namespace App\Modules\Structure\Models\Lang;

use Illuminate\Database\Eloquent\Model;

class PageLang extends Model
{
    /**
     * primary key.
     *
     * @var string
     */
    protected $primaryKey = 'translation_id';
       
    /**
     * table name.
     *
     * @var string
     */
    protected $table = 'structure_pages_lang';

    /**
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * @var array
     */
    protected $fillable = ['seo_title', 'seo_h1', 'seo_description', 'breacrumbs_title', 'head'];
}
