<?php
declare( strict_types = 1 );

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Class SlugService
 * @package App\Service
 */
class SlugService 
{
    /**
     * @param array $data
     * @param array $params
     * @return array
     */
    public function handleLangs(array $data, array $params = []) : array
    {
        $sourceField = !empty($params['sourceAttr']) ? $params['sourceAttr'] : 'title';
        $slugField = !empty($params['slugAttr']) ? $params['slugAttr'] : 'alias';
        
        foreach (config('translatable.locales') as $locale) {
            if (empty($data[$locale][$slugField])) {
                $data[$locale][$slugField] = $data[$locale][$sourceField];
            }
            $data[$locale][$slugField] = Str::slug($data[$locale][$slugField], '-');
        }
  
        return $data;
    }
}
