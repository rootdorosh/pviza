<?php

namespace App\Modules\Structure\Models\Lang;

use Illuminate\Database\Eloquent\Model;

class DomainLang extends Model
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
    protected $table = 'structure_domains_lang';

    /**
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * @var array
     */
    protected $fillable = ['copyright'];
}
