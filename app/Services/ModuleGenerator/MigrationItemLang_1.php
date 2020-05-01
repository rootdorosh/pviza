<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class MigrationItemLang
 */
class MigrationItemLang extends Base
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
            view()->file($this->gs->getViewBasePath() . 'database/migration_lang.blade.php', $viewData)->render());
    }
    
    /*
     * @return string
     */
    public function getClassName()
    {
        $parentModel = !empty($this->model['parentModel']) ? $this->model['parentModel'] : '';
        
        return !empty($this->model['migration']['name'])
            ? ucfirst(Str::camel($this->model['migration']['name']))
            : ucfirst(Str::camel($this->gs->config['module']['name'])) . $parentModel . $this->model['name'] . 'Lang';
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
     * @param string
     */
    public function getUp(): string
    {
        $items = [
            '$table->increments(\'translation_id\');',
            '$table->integer(\'' . $this->model['translatable']['owner_id'] . '\')->unsigned();',
            '$table->char(\'locale\', 2)->index();',
        ];
        
        foreach($this->model['translatable']['fields'] as $attr => $field) {
            $type = $field['type'];
            if (!empty($field['migration']['type'])) {
                $type = $field['migration']['type'];
            }
            $items[] = '$table->' . $type . '(\'' . $attr . '\')->nullable();';
        }
        
        $items = array_map(function($value){
            return "\t\t\t" . $value;
        }, $items);
        
        return implode("\n", $items);
    }
    
}
