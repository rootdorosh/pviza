<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class MigrationItem
 */
class MigrationItem extends Base
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
            'className' => $this->getClassName(),
            'up' => $this->getUp(),
        ]; 
       
        $this->gs->putFile($this->getPath(), 
            view()->file($this->gs->getViewBasePath() . 'database/migration.blade.php', $viewData)->render());
    }
    
    /*
     * @return string
     */
    public function getClassName()
    {
        $parentModel = !empty($this->model['parentModel']) ? $this->model['parentModel'] : '';
        
        return !empty($this->model['migration']['name'])
            ? ucfirst(Str::camel($this->model['migration']['name']))
            : ucfirst(Str::camel($this->gs->config['module']['name'])) . $parentModel . $this->model['name'];
    }
    
    /*
     * @return string
     */
    public function getPath(): string
    {
        return 'Database/migrations/' . date('Y_m_d_H00'). $this->model['id'] . 
            '_create_' . Str::snake($this->getClassName());
    }
    
    /*
     * @return string
     */
    public function getUp(): string
    {
        $items = [];
        if (empty($this->model['type'])) {
            $items[] = '$table->increments(\'id\');';
        }
        
        if (!empty($this->model['parentModel'])) {
            $items[] = '$table->unsignedInteger(\'' . Str::snake($this->model['parentModel']) . '_id\');';
        }
        
        foreach ($this->model['fields'] as $attr => $field) {
            
            if (array_key_exists('migration', $field) && $field['migration'] === false) {
                continue;
            }
            
            $type = $field['type'];
            if (!empty($field['migration']['type'])) {
                $type = $field['migration']['type'];
            }
            
            if(!empty($field['migration'])) {
                
                if ($type === 'double') {
                     $row = '$table->' . $type . '(\'' . $attr . '\', ' . $field['migration']['length'][0] . ', '. $field['migration']['length'][1] .')';
                } elseif ($type === 'enum') {
                    $row = '$table->' . $type . '(\'' . $attr . '\', ' . $field['migration']['value'] . ')';
                } else {
                    if (!empty($field['migration']['length'])) {
                        $row = '$table->' . $type . '(\'' . $attr .  '\', ' . $field['migration']['length'] . ')';
                    } else {
                        $row = '$table->' . $type . '(\'' . $attr . '\')';
                    }
                }
                
                if (!empty($field['migration']['nullable'])) {
                    $row.= '->nullable()';
                }
                if (array_key_exists('default', $field['migration'])) {
                    $row.= '->default(\''. $field['migration']['default'] .'\')';
                }
                if (!empty($field['migration']['comment'])) {
                    $row.= '->comment(\''. $field['migration']['comment'] .'\')';
                }
                $row.= ';';
                $items[] = $row;
            } else {
                $items[] = '$table->' . $field['type'] . '(\'' . $attr . '\');';
            }
        } 
        
        $foreigns = [];
        
        foreach($this->model['fields'] as $attr => $field) {
            if(!empty($field['migration']['foreign'])) {
                $foreigns[] = '$table->foreign(\'' . $attr . '\')->references(\'id\')' . 
                    '->on(\'' . $field['migration']['foreign'][0] .'\')' . 
                    '->onDelete(\''. $field['migration']['foreign'][1] . '\');';        
            }
        }
        
        if (!empty($this->model['parentModel'])) {
            
                $parentModelConf = $this->getConfigParentModel();
             
                $foreigns[] = '$table->foreign(\'' . Str::snake($this->model['parentModel']) . '_id\')->references(\'id\')' . 
                    '->on(\'' . $parentModelConf['table'] .'\')' . 
                    '->onDelete(\'CASCADE\');';        
        }
        
        if (!empty($foreigns)) {
            $items[] = '';
            $items = array_merge($items, $foreigns);
        }
        
        
        if (!empty($this->model['migration']['primary'])) {
            $items[] = '$table->primary([\''. implode("', '", $this->model['migration']['primary']) .'\']);';
        }
        
        
        
        $items = array_map(function($value){
            return "\t\t\t" . $value;
        }, $items);
        
        return implode("\n", $items);
    }
    
}
