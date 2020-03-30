<?php

namespace App\Modules\Structure\Services\Crud;

use App\Modules\Structure\Models\Domain;
use App\Services\Image\ImageService;


/**
 * Class DomainCrudService
 */
class DomainCrudService
{
    /**
     * @var ImageService
     */
    private $imageService;

    /**
     * DomainCrudService constructor.
     *
     * @param ImageManagerInterface $imageService
     */
    public function __construct(ImageService $imageService) 
    {
        $this->imageService = $imageService;
    }

    /*
     * @param   array $data
     * @return  Domain
     */
    public function store(array $data): Domain
    {
        $data = $this->attatchMedia($data);
        $domain = Domain::create($data);
        
        return $domain;
    }

    /*
     * @param   Domain $domain
     * @param   Domain $data
     * @return  Domain
     */
    public function update(Domain $domain, array $data): Domain
    {
        $data = $this->attatchMedia($data);
        $domain->update($data);
        
        return $domain;
    }

    /*
     * @param  array $data
     * @return array
     */
    public function attatchMedia(array $data): array
    {
        if (!empty($data['logo_base64'])) {
            $data['logo'] = $this->imageService->saveFromBaimageServicese64($data['logo_base64'], [
                'name' => $data['logo_name'],
            ]);
        }
        
        return $data;
    }

    /*
     * @param   Domain $domain
     * @return  void
     */
    public function destroy(Domain $domain): void
    {
        $domain->delete();
    }
    
    /*
     * @param   array $ids
     * @return  void
     */
    public function bulkDestroy(array $ids): void
    {
        Domain::destroy($ids);
    }
    
   
}
