<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Services\Crud;

use Illuminate\Support\Str;
use App\Modules\Vacancy\Models\Vacancy;
use App\Services\Image\ImageService;

/**
 * Class VacancyCrudService
 */
class VacancyCrudService
{
    /**
     * @var  ImageService
     */
     
    private $imageService;

    /*
    * @param  ImageService $imageService
    */
    public function __construct(   
        ImageService $imageService         
    )    
    {    
        $this->imageService = $imageService;        
    }

    /*
     *      
     * @param    array $data
     * @return  Vacancy
     */
    public function store(array $data): Vacancy
    { 
        foreach (config('translatable.locales') as $locale) {
            if (empty($data[$locale]['alias'])) {
                $data[$locale]['alias'] = $data[$locale]['title'];
            }
            $data[$locale]['alias'] = Str::slug($data[$locale]['alias']);
        }
        
        $data = $this->attatchMedia($data);          
        $vacancy = Vacancy::create($data);
        $this->syncRelations($vacancy, $data);
                
        return $vacancy;
	}

    /*
     *      
     * @param    Vacancy $vacancy
     * @param    Vacancy $data
     * @return  Vacancy
     */
    public function update(Vacancy $vacancy, array $data): Vacancy
    { 
        foreach (config('translatable.locales') as $locale) {
            if (empty($data[$locale]['alias'])) {
                $data[$locale]['alias'] = $data[$locale]['title'];
            }
            $data[$locale]['alias'] = Str::slug($data[$locale]['alias']);
        }

        $data = $this->attatchMedia($data, $vacancy);
        $vacancy->update($data);
        $this->syncRelations($vacancy, $data);
                
        return $vacancy;
    }

    /*
     * @param    Vacancy $vacancy
     * @return  void
     */
    public function destroy(Vacancy $vacancy): void
    {
        $vacancy->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Vacancy::destroy($ids);
    }    
      
    /*
     * @param    array $data
     * @param    Vacancy $vacancy
     * @return  array
     */
    public function attatchMedia(array $data, Vacancy $vacancy = null): array
    {     
        $data = $this->imageService->attachImage('image', $data, $vacancy);
        
        return $data;
    }
  

    /**
     * Sync relations vacancies
     *
     * @param  Vacancy $vacancies
     * @param  array $data
     * @return  void
     */
    public function syncRelations(Vacancy $vacancy, array $data) : void
    {
        $vacancy->categories()->sync(!empty($data['categories']) ? $data['categories'] : []);         $vacancy->types()->sync(!empty($data['types']) ? $data['types'] : []);         $vacancy->locations()->sync(!empty($data['locations']) ? $data['locations'] : []);       
	}
    
}