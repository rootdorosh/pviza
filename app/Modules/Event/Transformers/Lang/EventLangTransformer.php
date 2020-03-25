<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Transformers\Lang;

use App\Modules\Event\Models\Event;
use App\Modules\Event\Models\Lang\EventLang;
use App\Base\AbstractTransformer;

/**
 * Class EventLangTransformer.
 */
class EventLangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param  EventLang $eventLang
     * @return  array
     */
    public function transform(EventLang $eventLang) : array
    {
        $data = [
            'locale' => $eventLang->locale,
        ];
        
        foreach ((new Event)->translatedAttributes as $attr) {
            $data[$attr] = $eventLang->$attr;
        }
        
        return $data;
    }    
}
