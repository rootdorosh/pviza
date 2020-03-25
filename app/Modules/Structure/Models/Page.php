<?php

namespace App\Modules\Structure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\Translatable\Translatable;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Page extends Model
{
    use Translatable, Cacheable, Logable;
  
    /**
     * @var bool
     */
    public $timestamps = false;
    
    /*
     * @var string
     */
    public $table = 'structure_pages';

    /*
     * @var array
     */
    public $translatedAttributes = ['seo_title', 'seo_h1', 'seo_description', 'breacrumbs_title', 'head'];

    /*
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain_id', 
        'structure_id',
        'template_id', 
        'alias', 
        'is_search', 
        'is_canonical', 
        'is_breadcrumbs', 
        'is_menu', 
        'body_class', 
    ];  
    
    /**
     * Get the domain.
     *
     * @return BelongsTo
     */
    public function domain() : BelongsTo
    {
        return $this->belongsTo('App\Modules\Structure\Models\Domain');
    }
    
    /**
     * Get blocks
    *
    * @return HasMany
    */
    public function blocks() : HasMany
    {
        return $this->hasMany('App\Modules\Structure\Models\Block');
    }
    
}