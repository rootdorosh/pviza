<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class Seeder
 */
class Seeder extends Base
{
    /*
     * @return void
     */
    public function generate(): void
    {
        if (!empty($this->model['parentModel']) || 
            (!empty($this->model['exceptClass']) && in_array('Seeder', $this->model['exceptClass']))
        ) {
            return;
        }
            
        $moduleName = $this->gs->config['module']['name'];
        $modelName = $this->model['name'];
        
        $viewData = [
            'childrenModels' => $this->getChildrenModels(),
            'model' => $this->model,
            'moduleName' => $this->gs->config['module']['name'],
            'count' => !empty($this->model['seeder']['count']) ? $this->model['seeder']['count'] : 10,
            'source' => !empty($this->model['seeder']['source']) ? $this->model['seeder']['source'] : false,
        ]; 
         
        $view = $viewData['source'] ? 'seeder_source' : 'seeder_faker';
        
        $this->gs->putFile('Database/Seeds/' . $this->model['name'] . 'Seeder', 
            view()->file($this->gs->getViewBasePath() . 'database/' . $view . '.blade.php', $viewData)->render());
    }
    
    /*
     * @return string
     */
    public function getMeta(): string
    {
        return $raw;
    }
}
