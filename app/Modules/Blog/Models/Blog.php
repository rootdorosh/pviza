<?php

declare( strict_types = 1 );

namespace App\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\Image\Thumbnailable;
use App\Services\Translatable\Translatable;
use App\Base\Traits\Cacheable;
use App\Base\Traits\Logable;

class Blog extends Model
{
    use Thumbnailable, Translatable, Cacheable, Logable;

    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'blog';

    /**
     * @var  string
     */
	public $translationForeignKey = 'blog_id';

    /*
     * @var  array
     */
    public $translatedAttributes = [
        'title',
        'alias',
        'description',
        'seo_h1',
        'seo_title',
        'seo_description',
    ];

    /*
     * @var  array
     */
    protected $with = ['translations'];

    /**
     * The attributes that are mass assignable.

     * @var  array
     */
    public $fillable = [
        'category_id',
        'is_active',
        'is_home',
        'image',
        'image_header',
        'created_at',
    ];

    /**
     * Get the category.
     *
     * @return  BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo('App\Modules\Blog\Models\Category');

	}

	/**
	* Set attribute created_at.
	*/
	public function setCreatedAtAttribute($value)
	{
		if (!is_int($value)) {
			$value = strtotime($value);
		}
		$this->attributes['created_at'] = $value;
	}
}
