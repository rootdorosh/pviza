<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;
use App\Base\ScmsHelper;

/**
 * class Vue
 */
class Vue
{
    /*
     * @var ModuleGeneratorService
     */
    private $generatorService;
    
    /*
     * @param ModuleGeneratorService  $generatorService
     */
    public function __construct(ModuleGeneratorService $generatorService)
    {
        $this->generatorService = $generatorService;
    }

    /*
     * @param array $except
     * @return array
     */
    public function getModules(array $except = []): array
    {
        $activeModules = [];
        foreach (ScmsHelper::getModules() as $module) {
            if (is_dir($this->getModulePath($module)) &&
                !in_array($module, $except)
            ) {
                $activeModules[] = $module;
            }
        }
        
        return $activeModules;
    }

    /*
     * @return void
     */
    public function sync(): void
    {
        $this->syncRouter();
        $this->syncStore();
    }

    /*
     * @return void
     */
    public function syncRouter(): void
    {
        // except module auth
        $data['modules'] = $this->getModules(['Auth']);
        foreach ($data['modules'] as $module) {
            $data['modulesModule'][] = $module . 'Module';
        }
        
        //dd($data);
        
        $this->putFile('Routes.js', view()->file($this->generatorService->getViewBasePath() . 'vuejs/global_routes.blade.php', $data)->render());
    }
    
    /*
     * @return void
     */
    public function syncStore(): void
    {
        $modules = $this->getModules();
        $stores = [];
        
        foreach ($modules as $module) {
            $fileStoreMap = $this->getModulePath($module) . 'storeMap.js';
            if (is_file($fileStoreMap)) {
                $decoded = json_decode(file_get_contents($fileStoreMap), true);
                if (is_array($decoded)) {
                    foreach ($decoded as $items) { 
                        foreach ($items as $k => $v) {
                            $stores[$k] = $v;
                        }
                    }
                }
            }
        }
        
        $this->putFile('store.js', view()->file($this->generatorService->getViewBasePath() . 'vuejs/global_store.blade.php', compact('stores'))->render());
    }
    
    /*
     * @param string $file
     * @param string $content
     * @return void
     */
    protected function putFile(string $file, string $content): void
    {
        $path =  $this->getBasePath() . $file;
        file_put_contents($path, $content);
    }
    
    /*
     * @return string
     */
    protected function getBasePath(): string
    {
        return resource_path() . '/scms/src/';
    }
    
    /*
     * @param string $module
     * @return string
     */
    protected function getModulePath(string $module): string
    {
        return resource_path() . '/scms/src/modules/' . Str::camel($module) . '/';
    }
    
    
}
