<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class Factory
 */
class Factory extends Base
{
    /*
     * @return void
     */
    public function generate(): void
    {
        if (!empty($this->model['exceptClass']) && 
            in_array('Factory', $this->model['exceptClass'])
        ) {
            return;
        }
        
        $tab5 = "                    ";
        $tab4 = "                ";
        $tab3 = "            ";
        $tab2 = "       ";
        $tab1 = "   ";
        
        $raw = $tab1 . '$fakerService = resolve(\'\App\Services\Faker\FakerService\');' . "\n\n";
        $raw.= $tab1 . '$data = [' . "\n";
    
        foreach ($this->model['fields'] as $attr => $field) {
            if (!empty($field['faker'])) {
                $raw .= $tab2 . '\'' . $attr . '\' => ' . $field['faker'] . ",\n";
            }
        }
        $raw.= $tab1 . "];\n";
        
        if (!empty($this->model['translatable'])) {
            $raw .= "\n".$tab1 . 'foreach (config(\'translatable.locales\') as $locale) {' . "\n";
            foreach ($this->model['translatable']['fields'] as $attr => $field) {
                 $raw .= $tab2 . '$data[$locale][\'' . $attr . '\'] = ' .  $field['faker'] . ';' . "\n";
            }
            $raw .= $tab1 . "}\n";
        }

        $raw .= "\n".$tab1 . 'return $data;' . "\n";
        
        
        $viewData = [
            'model' => $this->model,
            'moduleName' => $this->gs->config['module']['name'],
            'raw' => $raw,
            'modelPath' => $this->getModelPath(),
        ]; 
         
        $this->gs->putFile('Database/factories/' . $this->getModelName() . 'Factory', 
            view()->file($this->gs->getViewBasePath() . 'database/factory.blade.php', $viewData)->render()); 
    }
    
    /*
     * @return string
     */
    public function getModelPath()
    {
        $path = 'App\Modules\\' . $this->gs->config['module']['name'] . '\Models';
        if (!empty($this->model['parentModel'])) {
            $path.= '\\' . $this->model['parentModel'];
        }
        $path.= '\\' . $this->model['name'];
        return $path;
    }
}
