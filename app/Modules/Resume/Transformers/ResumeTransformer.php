<?php 

declare( strict_types = 1 );

namespace App\Modules\Resume\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Resume\Models\Resume;

/**
 * Class ResumeTransformer.
 */
class ResumeTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'vacancy_title',
		'created_at',
		'name',
		'email',
		'phone'
    ];

    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = [
        'vacancy_id',
		'created_at',
		'name',
		'email',
		'phone',
		'message',
		'document'
    ];

    /**
     * List of item resource to include
     *
     * @var  array
     */
    public $itemIncludes = [
        'vacancy_title',
		'created_at',
		'name',
		'email',
		'phone',
		'message',
		'document'
    ];

    /**
     * transform
     *
     * @param  Resume $resume
     * @return  array
     */
    public function transform(Resume $resume) : array
    {
        return [
            'id' => $resume->id,
        ];
    }    
    
    /**
     * Include vacancy_id
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeVacancyId(Resume $resume)
    {
        return $this->primitive($resume->vacancy_id);
    }
    
    /**
     * Include vacancy_title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeVacancyTitle(Resume $resume)
    {
        return $this->primitive($resume->vacancy->title);
    }
    
    /**
     * Include created_at
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeCreatedAt(Resume $resume)
    {
        return $this->primitive(
			$resume->created_at
				? date(config('scms.datetime_format'), $resume->created_at)
				: null
		);

    }
    
    /**
     * Include name
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeName(Resume $resume)
    {
        return $this->primitive($resume->name);
    }
    
    /**
     * Include email
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeEmail(Resume $resume)
    {
        return $this->primitive($resume->email);
    }
    
    /**
     * Include phone
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includePhone(Resume $resume)
    {
        return $this->primitive($resume->phone);
    }
    
    /**
     * Include message
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeMessage(Resume $resume)
    {
        return $this->primitive($resume->message);
    }
    
    /**
     * Include document
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeDocument(Resume $resume)
    {
        return $this->primitive($resume->getFileUrl());
    }

}
