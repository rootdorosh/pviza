<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Transformers\Lang;

use App\Modules\Vacancy\Models\Vacancy;
use App\Modules\Vacancy\Models\Lang\VacancyLang;
use App\Base\AbstractTransformer;

/**
 * Class VacancyLangTransformer.
 */
class VacancyLangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param  VacancyLang $vacancyLang
     * @return  array
     */
    public function transform(VacancyLang $vacancyLang) : array
    {
        $data = [
            'locale' => $vacancyLang->locale,
        ];
        
        foreach ((new Vacancy)->translatedAttributes as $attr) {
            $data[$attr] = $vacancyLang->$attr;
        }
        
        return $data;
    }    
}
