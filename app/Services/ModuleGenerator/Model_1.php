<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class Model
 */
class Model extends Base
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
            'relations' => $this->getRelations(),
            'relationsTypes' => $this->getRelationsTypes(),
            'mutators' => $this->getMutators(),
        ]; 
       
        $this->gs->putFile($this->getPath(), 
            view()->file($this->gs->getViewBasePath() . 'models/model.blade.php', $viewData)->render());
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
        $path.= '/' . $this->model['name'];
        
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
        
        return $namespace;
    }    

    /*
     * @return array
     */
    public function getRelationsTypes(): array
    {
        $types = [];
        foreach ($this->getRelations() as $item) {
            $types[$item['type']] = $item['type'];
        }
        return $types;
    }    
    
    /*
     * @return array
     */
    public function getRelations(): array
    {
        $relations = [];
        foreach ($this->model['fields'] as $attr => $item) {
            if (!empty($item['relation'])) {
                $relations[] = $item['relation'];
            }    
        }
        if (!empty($this->model['parentModel'])) {
            $relations[] = [
                'name' => Str::camel($this->model['parentModel']),
                'type' => 'BelongsTo',
                'model' => $this->model['usePath'],                
            ];
        } 
        
        foreach ($this->getChildrenModels() as $childModel) {
            $relations[] = [
                'name' => Str::camel($childModel['name_plural']),
                'type' => 'HasMany',
                'model' => $childModel['usePath'],                
            ];            
        }
        
        return $relations;
    }   
    
    public function getMutators(): string
    {
        $s = '';
        
        foreach ($this->model['fields'] as $key => $field) {
            if (!empty($field['mutator']['set'])) {
                $s .= "\n\t" . '/**' . "\n";
                $s .= "\t" . '* Set attribute '.$key.'.' . "\n";
                $s .= "\t" . '*/' . "\n";
                
                $s .= "\t" . 'public function set'.Str::studly($key).'Attribute($value)' . "\n";
                $s .= "\t" . '{' . "\n";
            
                if ($field['mutator']['set'] === 'fromDatetimeToInt') {
                    $s .= "\t\t" . 'if (!is_int($value)) {' . "\n";
                    $s .= "\t\t\t" . '$value = strtotime($value);' . "\n";
                }
                $s .= "\t\t" . '}' . "\n";
                $s .= "\t\t" . '$this->attributes[\''.$key.'\'] = $value;' . "\n";
                $s .= "\t" . '}' . "\n";    
            }
        }
        
        return $s;
    }
    
    
}
