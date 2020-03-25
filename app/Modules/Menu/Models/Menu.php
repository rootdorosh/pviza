<?php 

declare( strict_types = 1 );

namespace App\Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Menu extends Model
{
    use Cacheable, Logable;
    
	CONST SM_CHANGEFREQ_ALWAYS = 1;
	CONST SM_CHANGEFREQ_HOURLY = 2;
	CONST SM_CHANGEFREQ_DAILY = 3;
	CONST SM_CHANGEFREQ_WEEKLY = 4;
	CONST SM_CHANGEFREQ_MONTHLY = 5;
	CONST SM_CHANGEFREQ_YEARLY = 6;
	CONST SM_CHANGEFREQ_NEVER = 7;
	CONST SM_CHANGEFREQS = [
		self::SM_CHANGEFREQ_ALWAYS => 'always',
		self::SM_CHANGEFREQ_HOURLY => 'hourly',
		self::SM_CHANGEFREQ_DAILY => 'daily',
		self::SM_CHANGEFREQ_WEEKLY => 'weekly',
		self::SM_CHANGEFREQ_MONTHLY => 'monthly',
		self::SM_CHANGEFREQ_YEARLY => 'yearly',
		self::SM_CHANGEFREQ_NEVER => 'never',
	];
    
    const SM_PRIORITIES = [
        '0.0' => '0.0',
        '0.1' => '0.1',
        '0.2' => '0.2',
        '0.3' => '0.3',
        '0.4' => '0.4',
        '0.5' => '0.5',
        '0.6' => '0.6',
        '0.7' => '0.7',
        '0.8' => '0.8',
        '0.9' => '0.9',
        '1.0' => '1.0',
    ];
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'menu';
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $casts = [
        'items' => 'array',
        'title' => 'string',
        'is_active' => 'int',
        'is_sitemap' => 'int', 
    ];  
  
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'domain_id',
        'title',
        'is_active',
        'is_sitemap', 
    ];  
  
    /**
     * Get the domain.
     *
     * @return  BelongsTo
     */
    public function domain() : BelongsTo
    {
        return $this->belongsTo('App\Modules\Structure\Models\Domain');
    }
   
     
}