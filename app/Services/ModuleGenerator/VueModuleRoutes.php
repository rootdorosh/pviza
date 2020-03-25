<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class VueModuleRoutes
 */
class VueModuleRoutes
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
        $routeFile = $this->getRoutesFile();
        
        if (!is_file($routeFile)) {
            $this->createFile();
        }  else {
            $this->updateFile();
        }     
    }   
    
    /*
     * @return void
     */

    protected function createFile(): void
    {
        $data = (new VueRoutes)->getDataFormatted(
            (new VueRoutes)->getData($this->model)
        );
        $this->generatorService->putVueFile('routes', 'js', view()->file(
            $this->generatorService->getViewBasePath() . 'vuejs/routes.blade.php', $data)->render()
        );
    }   
    
    /*
     * @return void
     */

    protected function updateFile(): void
    {
        $routeFile = $this->getRoutesFile();
        
        $data = $this->removeModelData($this->parseFile($routeFile), $this->model);
        $modelData = (new VueRoutes)->getData($this->model);
        if (!empty($modelData['imports'])) {
            foreach ($modelData['imports'] as $compName => $include) {
                $data['imports'][$compName] = $include;
            }
        }
        if (!empty($modelData['map'])) {
            foreach ($modelData['map'] as $val) {
                $isset = false;
                if (!empty($data['map'])) {
                    foreach ($data['map'] as $item) {
                        if ($item['name'] === $val['name']) {
                            $isset = true;
                        }
                    }
                }
                if (!$isset) {
                    $data['map'][] = $val;
                }
            }
        }
        
        $data = (new VueRoutes)->getDataFormatted($data);
        
        
        $this->generatorService->putVueFile('routes', 'js', view()->file(
            $this->generatorService->getViewBasePath() . 'vuejs/routes.blade.php', $data)->render()
        );
    }   
    
    /*
     * @param array $data
     * @param array $model
     * @return array
     */

    protected function removeModelData(array $data, array $model): array
    {
        $modelComponents = [];
        foreach (['index', 'create', 'update'] as $key) {
            $modelComponents[] = $model['vue']['componentName'] . ucfirst($key);
        }
        
        if (!empty($data['imports'])) {
            foreach ($data['imports'] as $comp => $import) {
                if (in_array($comp, $modelComponents)) {
                    unset($data['imports'][$comp]);
                }
            }
        }
        if (!empty($data['map'])) {
            foreach ($data['map'] as $i => $item) {
                if (in_array($item['component'], $modelComponents)) {
                    unset($data['map'][$i]);
                }
            }
        }
            
        return $data;
    }
    
    /*
     * @param string $file
     * @return array
     */

    protected function parseFile(string $file): array
    {
        $data = [];
        
        $content = file_get_contents($file);
        
        $contentImport = Str::before($content, 'export default');
        $contentImport = str_replace(["\r"], "", $contentImport);
        $imports = explode("\n", $contentImport);
        
        $imports = array_filter($imports, function ($value) {
            return substr_count($value, 'import');
        });
        foreach ($imports as $import) {
            preg_match("/mport (.*?) from/", $import, $match);
            if (isset($match[1])) {
                $data['imports'][$match[1]] = $import;
            }
        }
        
        $contentMap = Str::after($content, 'export default');
        $contentMap = str_replace(["\n", " ", "\r"], "", $contentMap);
        
        preg_match_all("/{path:'(.*?)',name:'(.*?)',component:(.*?),}/", $contentMap, $matches);
        
        foreach ($matches[1] as $i => $item) {
           $data['map'][] = [
               'path' => $matches[1][$i],
               'name' => $matches[2][$i],
               'component' => $matches[3][$i],
           ]; 
        }
        
        return $data;
    }   
    
    
    
    /*
     * @return string
     */

    protected function getRoutesFile(): string
    {
        return $this->generatorService->getVueModulePath() . 'routes.js';
    }   
    
}
