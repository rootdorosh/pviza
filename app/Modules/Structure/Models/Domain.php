<?php

namespace App\Modules\Structure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\Translatable\Translatable;
use App\Services\Image\Thumbnailable;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;


class Domain extends Model
{
    use Translatable, Thumbnailable, Logable, Cacheable;
        
    /**
     * @var bool
     */
    public $timestamps = false;
    
    /*
     * @var string
     */
    public $table = 'structure_domains';

    /*
     * @var array
     */
    public $translatedAttributes = ['copyright'];

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
        'alias', 'is_active', 'site_lang', 'site_langs', 'logo', 'menus',
    ];  

    /**
     * @var array
     */
    protected $casts = [
        'site_langs' => 'array',
    ];
    
    /**
     * @return HasMany
     */
    public function pages(): HasMany
    {
        return $this->hasMany('App\Modules\Structure\Models\Page');
    }    

}
