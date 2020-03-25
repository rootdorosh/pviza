<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Transformers\Lang;

use App\Modules\Vacancy\Models\Location;
use App\Modules\Vacancy\Models\Lang\LocationLang;
use App\Base\AbstractTransformer;

/**
 * Class LocationLangTransformer.
 */
class LocationLangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param  LocationLang $locationLang
     * @return  array
     */
    public function transform(LocationLang $locationLang) : array
    {
        $data = [
            'locale' => $locationLang->locale,
        ];
        
        foreach ((new Location)->translatedAttributes as $attr) {
            $data[$attr] = $locationLang->$attr;
        }
        
        return $data;
    }    
}
