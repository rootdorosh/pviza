<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class Controller
 */
class Controller extends Base
{
    /*
     * @return void
     */
    public function generate(): void
    {
        $modelName = $this->getModelName();
        $moduleName = $this->gs->config['module']['name'];
        $modelShortName = $this->model['name'];
        $parentModel = !empty($this->model['parentModel']) ? $this->model['parentModel'] : '';
        
        $dependencies = array_map(function($value) use ($moduleName, $modelShortName, $parentModel){
            return str_replace(['%module%', '%model%', '%parent%'], [$moduleName, $modelShortName, $parentModel], $value);
        }, $this->model['depedencies']['controller']);
        
        $dependenciesUse = array_map(function($value){
            return 'use ' . $value;
        }, $dependencies);

        $dependenciesVars = [];
        foreach ($dependencies as $dep) {
            $name = Str::afterLast($dep, '\\');
            
            $dependenciesVars[Str::camel(str_replace([$moduleName, $this->model['name']], '', $name))] = $name;
        }
        
        $requests = [
            'MetaRequest',
            'IndexRequest',
            'DestroyRequest',
            'BulkDestroyRequest',            
        ];
        
        if (!( !empty($this->model['exceptCrud']) && in_array('update', $this->model['exceptCrud'])) ||
            !( !empty($this->model['exceptCrud']) && in_array('store', $this->model['exceptCrud'])) 
        ) {
            $requests[] = 'FormRequest';
        }
        if (!( !empty($this->model['exceptCrud']) && in_array('update', $this->model['exceptCrud']) && empty($this->model['uiView']))) {
            $requests[] = 'ShowRequest';
        }
        
        if (!empty($this->model['parentModel'])) {
            $requests[] = 'SortableRequest';
        }
        
        $viewData = [
            'model' => $this->model,
            'moduleName' => $this->gs->config['module']['name'],
            'modelName' => $modelName,
            'dependenciesUse' => $dependenciesUse,
            'dependenciesVars' => $dependenciesVars,
            'meta' => $this->getMeta(),
            'namespace' => $this->getNamespace(),
            'requestNamespace' => $this->getRequestNamespace(),
            'responsePath' => $this->getStorageResponsePath(),
            'functionSignatureTitle' => $this->getFunctionSignatureTitle(),
            'signatureParams' => $this->getSignatureParams(),
            'signatureParamsDelimeter' => $this->gs->getValueFromKeyVal($this->getSignatureParams()),
            'namespaceModels' => $this->getNamespaceModels(),
            'requests' => $requests,
        ]; 
        
        $this->gs->putFile($this->getPath(), 
            view()->file($this->gs->getViewBasePath() . 'http/controller.blade.php', $viewData)->render());
    }
    
    /*
     * @return string
     */
    public function getPath(): string
    {
        $path = 'Http/Controllers';
        
        if (!empty($this->model['parentModel'])) {
            $path.= '/' . $this->model['parentModel'];
        }
        $path.= '/' . $this->model['name'] . 'Controller';
        
        return $path;
    }
    
    /*
     * @return string
     */
    public function getFunctionSignatureTitle(): string
    {
        if (!empty($this->model['parentModel'])) {
            return $this->model['parentModel'] . ' ' . strtolower($this->model['name_plural']);
        } else {
            return $this->model['name_plural'];
        }
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
        $namespace = 'App\Modules\\' . $this->gs->config['module']['name'] . '\Http\Controllers';
        
        if (!empty($this->model['parentModel'])) {
            $namespace.= '\\' . $this->model['parentModel'];
        }
        
        return $namespace;
    }
    
    /*
     * @return string
     */
    public function getRequestNamespace(): string
    {
        $namespace = 'App\Modules\\' . $this->gs->config['module']['name'] . '\Http\Requests';
        
        if (!empty($this->model['parentModel'])) {
            $namespace.= '\\' . $this->model['parentModel'];
        }
        $namespace.= '\\' . $this->model['name'];
        
        return $namespace;
    }
    
    /*
     * @return string
     */
    public function getMeta(): string
    {
        $raw = "return response()->json([\n";
        $raw.= "\t\t\t'labels' => __('". Str::camel($this->gs->config['module']['name']) ."::" . Str::snake($this->getModelName())  . "'),\n";
        if (!empty($this->model['meta'])) {
            foreach ($this->model['meta'] as $metaKey => $metaItems) {
                $raw.= "\t\t\t'" . $metaKey . "' => [\n";
                foreach ($metaItems as $k => $v) {
                    $raw.= "\t\t\t\t'{$k}' => {$v},\n";
                }
                $raw.= "\t\t\t],\n";
            }    
        }
        
        if (!empty($this->getAdaptiveImages())) {
            $raw.= "\t\t\t" . "'adaptive_images' => ExtArrHelper::adaptiveImage('" . $this->getModuleName() . "', '" . $this->model['nameWithParentPrefix'] . "'),\n";
        }    
            
        if (!empty($this->model['parentModel'])) {
            $raw.= "\t\t\t" . "'model' => [\n";
            $raw.= "\t\t\t\t" . "'fields' => [\n";
            foreach ($this->model['fields'] as $attr => $field) {
                if (in_array($attr, ['rank'])) {
                    continue;
                }
                
                $required = !empty($field['required']) && $field['required'] ? 'true' : 'false';
                $default = !empty($field['default']) && $field['default'] ? $field['default'] : '';
                if (empty($default)) {
                    $default = !empty($field['migration']['default']) ? $field['migration']['default'] : '';
                }
                
                $raw.= "\t\t\t\t\t" . "'{$attr}' => [\n";
                $raw.= "\t\t\t\t\t\t'type' => '".$field['uiType']."',\n";
                $raw.= "\t\t\t\t\t\t'required' => ".$required.",\n";
                if (!empty($default)) {
                    $raw.= "\t\t\t\t\t\t'default' => ".$default.",\n";
                }
                
                if ($field['uiType'] === 'select') {
                    $raw.= "\t\t\t\t\t\t'options' => ".$field['options'].",\n";
                }
                $raw.= "\t\t\t\t\t],\n";
            }
            $raw.= "\t\t\t\t],\n";
            
            if (!empty($this->model['translatable'])) {
                $raw.= "\t\t\t\t" . "'translatable' => [\n";
                foreach ($this->model['translatable']['fields'] as $attr => $field) {
                    $required = !empty($field['required']) && $field['required'] ? 'true' : 'false';

                    $raw.= "\t\t\t\t\t" . "'{$attr}' => [\n";
                    $raw.= "\t\t\t\t\t\t'type' => '".$field['uiType']."',\n";
                    $raw.= "\t\t\t\t\t\t'required' => ".$required.",\n";
                    $raw.= "\t\t\t\t\t],\n";
                }
                $raw.= "\t\t\t\t],\n";
            }
            $raw.= "\t\t\t\t],\n";
        }
            
        $raw.= "\t\t]);\n";
        
        return $raw;
    }
}

/*

                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Заголовок',
                            'default' => 'xxx',
                        ],
                        'type' => [
                            'type' => 'select',
                            'label' => 'Тип',
                            'default' => 1,
                            'options' => [
                                1 => 'Фото',
                                2 => 'план',
                                3 => 'карта',
                            ],
                        ],
                    ],


 */
