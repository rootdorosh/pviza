<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class ModelLang
 */
class ModelLang extends Base
{
    /*
     * @return void
     */
    public function generate(): void
    {
        $modelName = $this->getModelName();
                
        $viewData = [
            'model' => $this->model,
            'moduleName' => $this->gs->config['module']['name'],
            'modelName' => $modelName,
            'namespace' => $this->getNamespace(),
        ]; 
       
        $this->gs->putFile($this->getPath(), 
            view()->file($this->gs->getViewBasePath() . 'models/model_lang.blade.php', $viewData)->render());
    }
    
    /*
     * @return string
     */
    public function getPath(): string
    {
        $path = 'Models';
        
        if (!empty($this->model['parentModel'])) {
            $path.= '/' . $this->model['parentModel'];
        }
        $path.= '/Lang/' . $this->model['name'] . 'Lang';
        
        return $path;
    }
                
    /*
     * @return string
     */
    public function getNamespace(): string
    {
        $namespace = 'App\Modules\\' . $this->gs->config['module']['name'] . '\Models';
        
        if (!empty($this->model['parentModel'])) {
            $namespace.= '\\' . $this->model['parentModel'];
        }
        
        return $namespace . '\\Lang';
    }    
}
