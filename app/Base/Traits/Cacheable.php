<?php

namespace App\Base\Traits;

use Cache;
use Illuminate\Database\Eloquent\Model;
use App\Base\ScmsHelper;

trait Cacheable
{
    public static function bootCacheable()
    {
        static::saved(function (Model $model) {
            $model->flush($model->getAllTags());
        });

        static::deleted(function (Model $model) {
            $model->flush($model->getAllTags());
        });
    }    
    
    /*
     * @param array $tags
     */
    public function flush(array $tags)
    {
        foreach ($tags as $tag) {
            Cache::tags($tag)->flush();
        }        
    }

    /*
     * @return string
     */
    public function getTag(): string
    {
        return ScmsHelper::getTag() . '_' . $this->table;
    }
    
    /*
     * @return array
     */
    public function getAllTags(): array
    {
        $tags = [$this->getTag()];
        if (method_exists($this, 'getTags')) {
            foreach ($this->getTags() as $tag) {
                $tags[] = $tag;
            }
        }
        return $tags;
    }
}
