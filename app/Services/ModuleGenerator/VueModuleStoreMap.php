<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class VueModuleStoreMap
 */
class VueModuleStoreMap
{
    /*
     * @var ModuleGeneratorService
     */
    private $generatorService;
    
    /*
     * @var array
     */
    private $model;
    
    /*
     * @param ModuleGeneratorService  $generatorService
     * @param , array $model
     */
    public function __construct(ModuleGeneratorService $generatorService, array $model)
    {
        $this->generatorService = $generatorService;
        $this->model = $model;
    }
    
    /*
     * @return void
     */

    public function generate(): void
    {
        $storeMapFile = $this->getStoreMapFile();
        
        if (!is_file($storeMapFile)) {
            $this->createFile();
        }  else {
            $this->updateFile();
        }     
    }   
    
    /*
     * @return array
     */
    protected function getModelStoreData(): array
    {
        $data = [];
        
        $moduleName = Str::camel($this->model['module']['name']);
        $modelName = Str::camel($this->model['name']);
        
        if ($this->model['pages']['index']) {
            $data[$this->model['vue']['stateName'] . 'Index'] = '@/modules/' . $moduleName . '/store/' . $modelName . '/index';
        }
        if ($this->model['pages']['update'] || $this->model['pages']['create']) {
            $data[$this->model['vue']['stateName'] . 'Form'] = '@/modules/' . $moduleName . '/store/' . $modelName . '/form';
        }
        //dd($this->model['pages']);
        if ($this->model['pages']['view']) {
            $data[$this->model['vue']['stateName'] . 'View'] = '@/modules/' . $moduleName . '/store/' . $modelName . '/view';
        }
        
        return $data;
    }   
    
    /*
     * @param array $data
     * @return array
     */
    protected function formatData(array $data): array
    {
        $items = [];
        foreach ($data as $k => $v) {
            $items[] = '{"' . $k . '": "' . $v . '"}'; 
        }
        return $items;
    }   
    
    /*
     * @return void
     */
    protected function createFile(): void
    {
        $data = $this->getModelStoreData();
        $items = $this->formatData($data);
        
        $this->generatorService->putVueFile('storeMap', 'js', view()->file(
            $this->generatorService->getViewBasePath() . 'vuejs/store_map.blade.php', compact('items'))->render()
        );
    }   
    
    /*
     * @return void
     */
    protected function updateFile(): void
    {
        $routeFile = $this->getStoreMapFile();
        
        $data = array_merge_recursive(
            $this->removeModelData($this->parseFile()), 
            $this->getModelStoreData()
        );
        $items = $this->formatData($data);
        
        $this->generatorService->putVueFile('storeMap', 'js', view()->file(
            $this->generatorService->getViewBasePath() . 'vuejs/store_map.blade.php', compact('items'))->render()
        );
    }   
    
    /*
     * @param array $data
     * @return array
     */

    protected function removeModelData(array $data): array
    {
        $modelStates = [];
        foreach (['index', 'form', 'view'] as $key) {
            $modelStates[] = $this->model['vue']['stateName'] . ucfirst($key);
        }
        
        foreach ($data as $i => $item) {
            if (in_array($i, $modelStates)) {
                unset($data[$i]);
            }
        }
        
        return $data;
    }
    
    /*
     * @return array
     */
    protected function parseFile(): array
    {
        $data = json_decode(file_get_contents($this->getStoreMapFile()), true);
        $data = is_array($data) ? $data : [];
        $items = [];
        foreach ($data as $states) {
            foreach ($states as $k => $v) {
                $items[$k] = $v;
            }
        }
        
        return $items;
    }   
    
    /*
     * @return string
     */
    protected function getStoreMapFile(): string
    {
        return $this->generatorService->getVueModulePath() . 'storeMap.js';
    }   
    
}
