<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class ServiceFetch
 */
class ServiceFetch extends Base
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
            'namespaceModels' => $this->getNamespaceModels(),
            'signatureParams' => $this->getSignatureParams(),
            'signatureParamsDelimeter' => $this->gs->getValueFromKeyVal($this->getSignatureParams()),
        ]; 
        
        $this->gs->putFile($this->getPath(), 
            view()->file($this->gs->getViewBasePath() . 'services/fetch.blade.php', $viewData)->render());
    }
    
    /*
     * @return array
     */
    public function getSignatureParams(): array
    {
        $data = [];
        if (!empty($this->model['parentModel'])) {
            $data[$this->model['parentModel']] = '$' . Str::camel($this->model['parentModel']);
        }
        
        return $data;
    }
    
    
    /*
     * @return string
     */
    public function getNamespace(): string
    {
        $namespace = 'App\Modules\\' . $this->gs->config['module']['name'] . '\Services\Fetch';
        
        if (!empty($this->model['parentModel'])) {
            $namespace.= '\\' . $this->model['parentModel'];
        }
        
        return $namespace;
    }
    
    /*
     * @return string
     */
    public function getPath(): string
    {
        $path = 'Services/Fetch/';
        
        if (!empty($this->model['parentModel'])) {
            $path.= '/' . $this->model['parentModel'];
        }
        $path.= '/' . $this->model['name'] . 'FetchService';
        
        return $path;
    }
}
