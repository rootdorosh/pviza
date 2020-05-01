<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class VueView
 */
class VueView extends Base
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
        ]; 
        
        $this->gs->putVueFile(
            'views/' . Str::camel($this->model['name']) . '/View/View', 
            'vue', 
            view()->file($this->gs->getViewBasePath() . 'vuejs/views/view.blade.php', $viewData)->render()
        );        
    }
   
}
