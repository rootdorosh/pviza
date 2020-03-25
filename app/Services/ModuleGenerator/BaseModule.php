<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class BaseModule
 */
class BaseModule
{
    /*
     * @var ModuleGeneratorService
     */
    protected $gs;
    
    /*
     * @var array
     */
    protected $models;
    
    /*
     * @param ModuleGeneratorService  $gs
     * @param  array $model
     */
    public function __construct(ModuleGeneratorService $gs, array $models)
    {
        $this->gs = $gs;
        $this->models = $models;
    }
    
    /*
     * @param array $model
     * @return array
     */
    public function getChildrenModels(array $model): array
    {
        $path = resource_path() . '/modules/' . Str::camel($this->gs->config['module']['name']) . '/models/*';
        $files = glob($path);
        
        $data = [];
        foreach ($files as $file) {
            $conf = require($file);
            if (!empty($conf['parentModel']) && $conf['parentModel'] === $model['name']) {
                $data[$conf['name']] = $this->gs->getExrendedModelConfig($conf);
            }
        }
        
        return $data;
    }    
}