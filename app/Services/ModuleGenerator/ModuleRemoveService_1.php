<?php

namespace App\Services\ModuleGenerator;

use Cache;
use App\Base\ScmsHelper;

/**
 * class ModuleRemoveService
 */
class ModuleRemoveService
{
    /*
     * @var ModuleGenerator
     */
    public $gs;

    /*
     * @var string
     */
    public $module;
        
    /*
     * @var array
     */
    public $config;
    
    /*
     * ModuleGeneratorService constructor
     * 
     * @param string $module
     * @return void
     */
    public function __construct(string $module)
    {
        $this->module = $module;
        $this->gs = new ModuleGeneratorService($module);
    }
    
    /*
     * Run generator
     * 
     * @return void
     */
    public function handle(): void
    {
        (new Migration($this->gs))->drop();
        
        if (is_dir($this->gs->getModulePath())) {
            rmDirRecursive($this->gs->getModulePath());
            echo "Dir: " . $this->gs->getModulePath() . " removed \n";
        } else {
            echo "No such file or directory: " . $this->gs->getModulePath() . "  \n";
        }
        
        if (is_dir($this->gs->getVueModulePath())) {
            //rmDirRecursive($this->gs->getVueModulePath());
            echo "Dir: " . $this->gs->getVueModulePath() . " removed \n";
        } else {
            echo "No such file or directory: " . $this->gs->getVueModulePath() . "  \n";
        }
        
        if (is_dir($this->gs->getPathTestModule())) {
            rmDirRecursive($this->gs->getPathTestModule());
            echo "Dir: " . $this->gs->getPathTestModule() . " removed \n";
        } else {
            echo "No such file or directory: " . $this->gs->getPathTestModule() . "  \n";
        }
        
        Cache::tags(ScmsHelper::TAG)->flush();
        (new Vue($this->gs))->sync();
    }
    
}    