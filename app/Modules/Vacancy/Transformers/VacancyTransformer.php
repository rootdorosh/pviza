<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Vacancy\Models\Vacancy;
use App\Modules\Vacancy\Transformers\Lang\VacancyLangTransformer;

/**
 * Class VacancyTransformer.
 */
class VacancyTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'is_active',
		'is_popular',
		'rank',
		'image',
		'title',
		'alias'
    ];

    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = [
        'lang',
		'categories',
		'types',
		'locations',
		'is_active',
		'is_popular',
		'rank',
		'date_posted',
		'hiring_organization',
		'image',
		'title',
		'alias',
		'salary',
		'work_schedule',
		'contract_type',
		'description',
		'seo_h1',
		'seo_title',
		'seo_description'
    ];

    /**
     * List of item resource to include
     *
     * @var  array
     */
    public $itemIncludes = [
        'lang',
		'categories',
		'types',
		'locations',
		'is_active',
		'is_popular',
		'rank',
		'date_posted',
		'hiring_organization',
		'image',
		'title',
		'alias',
		'salary',
		'work_schedule',
		'contract_type',
		'description',
		'seo_h1',
		'seo_title',
		'seo_description'
    ];

    /**
     * transform
     *
     * @param  Vacancy $vacancy
     * @return  array
     */
    public function transform(Vacancy $vacancy) : array
    {
        return [
            'id' => $vacancy->id,
        ];
    }    
    
    /**
     * Include categories
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeCategories(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->categories->pluck('id')->toArray());
    }
    
    /**
     * Include types
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeTypes(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->types->pluck('id')->toArray());
    }
    
    /**
     * Include locations
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeLocations(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->locations->pluck('id')->toArray());
    }
    
    /**
     * Include is_active
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsActive(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->is_active);
    }
    
    /**
     * Include is_popular
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsPopular(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->is_popular);
    }
    
    /**
     * Include rank
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeRank(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->rank);
    }
    
    /**
     * Include date_posted
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeDatePosted(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->date_posted);
    }
    
    /**
     * Include hiring_organization
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeHiringOrganization(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->hiring_organization);
    }
    
    /**
     * Include image
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeImage(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->getThumb('image', 100, 75, 'resize'));
    }
    
    /**
     * Include title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeTitle(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->title);
    }
    
    /**
     * Include alias
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeAlias(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->alias);
    }
    
    /**
     * Include salary
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSalary(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->salary);
    }
    
    /**
     * Include work_schedule
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeWorkSchedule(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->work_schedule);
    }
    
    /**
     * Include contract_type
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeContractType(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->contract_type);
    }
    
    /**
     * Include description
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeDescription(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->description);
    }
    
    /**
     * Include seo_h1
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoH1(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->seo_h1);
    }
    
    /**
     * Include seo_title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoTitle(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->seo_title);
    }
    
    /**
     * Include seo_description
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoDescription(Vacancy $vacancy)
    {
        return $this->primitive($vacancy->seo_description);
    }
    
    /**
     * Include lang
     *
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeLang(Vacancy $vacancy)
    {
        return $this->collection($vacancy->translations, new VacancyLangTransformer);
    }

}
