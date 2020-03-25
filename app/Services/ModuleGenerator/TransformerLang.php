<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class TransformerLang
 */
class TransformerLang extends Base
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
            'modelLangPath' => $this->getModelLangPath(),
        ]; 
       
        $this->gs->putFile($this->getPath(), 
            view()->file($this->gs->getViewBasePath() . 'transformers/transformer_lang.blade.php', $viewData)->render());
    }
    
    /*
     * @return string
     */
    public function getPath(): string
    {
        $path = 'Transformers';
        
        if (!empty($this->model['parentModel'])) {
            $path.= '/' . $this->model['parentModel'];
        }
        $path.= '/Lang/' . $this->model['name'] . 'LangTransformer';
        
        return $path;
    }
                
    /*
     * @return string
     */
    public function getNamespace(): string
    {
        $namespace = 'App\Modules\\' . $this->gs->config['module']['name'] . '\Transformers';
        
        if (!empty($this->model['parentModel'])) {
            $namespace.= '\\' . $this->model['parentModel'];
        }
        
        return $namespace . '\\Lang';
    }
    
    /*
     * @return string
     */
    public function getModelLangPath(): string
    {
        $modelPath = 'App\Modules\\' . $this->gs->config['module']['name'] . '\Models';
        if (!empty($this->model['parentModel'])) {
            $modelPath.= '\\' . $this->model['parentModel'];
        }
        
        return $modelPath . '\\Lang\\' . $this->model['name'] . 'Lang';
    }
    
}
