<?php
declare( strict_types = 1 );
namespace App\Modules\Resume\Services\Crud;

use App\Modules\Resume\Models\Resume;
use App\Modules\Event\Services\EventService;
use App\Services\File\FileService;

/**
 * Class ResumeCrudService
 */
class ResumeCrudService
{
    /*
     * @var EventService
     */
    private $eventService;
    
    /*
     * @var FileService
     */
    private $fileService;
    
    /*
     * @param EventService $authService
     * @param FileService $fileService
     */
    public function __construct(EventService $eventService, FileService $fileService)
    {
        $this->eventService = $eventService;
        $this->fileService = $fileService;
    }

    /*
     *      
     * @param    array $data
     * @return  Resume
     */
    public function store(array $data): Resume
    {
        $data = $this->uploadMedia($data);
        $data['created_at'] = time();
        
        $resume = Resume::create($data);
        $resume->refresh();
        
        $this->eventService->addToQueue('resume.send', [
            'vacancy' => $resume->vacancy->title,
            'uemail' => $resume->email,
            'name' => $resume->name,
            'phone' => $resume->phone,
            'message' => $resume->message,
            'file' => $resume->getFileUrl() ? '<a href="'.$resume->getFileUrl().'">File</a>': '',
        ]);        
        return $resume;
    }

    /*
     *      
     * @param    Resume $resume
     * @param    Resume $data
     * @return  Resume
     */
    public function update(Resume $resume, array $data): Resume
    {
        $resume->update($data);

        return $resume;
    }

    /*
     * @param    Resume $resume
     * @return  void
     */
    public function destroy(Resume $resume): void
    {
        $resume->delete();
    }

    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Resume::destroy($ids);
    }
   
    /*
     * @param    array $data
     * @return  array
     */
    public function uploadMedia(array $data): array
    {    
        $docs = [];
        if (!empty($data['file'])) {
            $data['document'] = $this->fileService->save($data['file']);
        }
        return $data;
    }
    

}
