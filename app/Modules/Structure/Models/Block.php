<?php

namespace App\Modules\Structure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Base\Traits\Logable;
use App\Base\Traits\Cacheable;

class Block extends Model
{
    use Logable, Cacheable;
  
    /**
     * @var bool
     */
    public $timestamps = false;
    
    /*
     * @var string
     */
    public $table = 'structure_pages_blocks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id', 
        'alias',
        'content', 
        'rank', 
    ];  
    
    /**
     * Get page.
    *
    * @return BelongsTo
    */
    public function page() : BelongsTo
    {
        return $this->belongsTo('App\Modules\Structure\Models\Page');
    }
    
    /*
     * @return array
     */
    public function getTags(): array
    {
        return [$this->getTag() . '_' . $this->page_id];
    }
    
}
