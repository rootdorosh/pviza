<?php 

declare( strict_types = 1 );

namespace App\Modules\Settings\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Modules\Settings\Models\Settings;
use App\Modules\Settings\Http\Requests\Settings\{
    MetaRequest,
	FormRequest
};
use App\Modules\Settings\Services\SettingsService;

/**
 * @group  SETTINGS
 */
class SettingsController extends Controller
{
    /**
     * @var  SettingsService
     */
    private $settingsService;
    
    /*
    * @param  SettingsService $settingsService
    */
    public function __construct(SettingsService $settingsService) 
    {    
        $this->settingsService = $settingsService;    
    }
    
    /**
     * Settings meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/settings/settings/meta/200.json
     *      
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json($this->settingsService->getMeta());
    }

    /**
     * Settings store
     *
     * @authenticated
     * 
     * @responseFile  201 responses/settings/settings/store/201.json
     * @responseFile  422 responses/settings/settings/store/422.json
     *      
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $this->settingsService->store($request->validated());
        
        return response()->json(null, 201);            
    }       
}