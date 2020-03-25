<?php

namespace App\Modules\Structure\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Structure\Models\Domain;
use App\Modules\Structure\Transformers\Lang\DomainLangTransformer;

/**
 * Class DomainTransformer.
 */
class DomainTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var array
     */
    protected $defaultIncludes = [
        'copyright',
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'lang',
        'copyright',
    ];

    /**
     * List of item resource to include
     *
     * @var array
     */
    public $itemIncludes = [
        'lang',
    ];

    /**
     * transform
     *
     * @param Domain $domain
     * @return array
     */
    public function transform(Domain $domain) : array
    {
        return [
            'id' => $domain->id,
            'alias' => $domain->alias,
            'is_active' => $domain->is_active,
            'site_lang' => $domain->site_lang,
            'site_langs' => $domain->site_langs,
            'menus' => $domain->menus,
            'logo' => $domain->getThumb('logo', 100, 75, 'crop'),
        ];
    }
    
    /**
     * Include lang
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeLang(Domain $domain)
    {
        return $this->collection($domain->translations, new DomainLangTransformer);
    }    
    
    /**
     * Include copyright
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeCopyright(Domain $domain)
    {
        return $this->primitive($domain->copyright);
    }    
    
}
