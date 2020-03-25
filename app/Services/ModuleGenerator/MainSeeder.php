<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;
use App\Base\ScmsHelper;

/**
 * class Routes
 */
class MainSeeder extends BaseModule
{
    /*
     * @return void
     */

    public function generate(): void
    {
        if (array_key_exists('seed', $this->gs->config['module']) && $this->gs->config['module'] === false) {
            return;
        }
        
        $models = [];
        foreach ($this->gs->config['models'] as $model) {
            if (!(!empty($model['parentModel']) || 
                (!empty($model['exceptClass']) && in_array('Seeder', $model['exceptClass'])))
            ) {
                if (!empty($model['name'])) {
                    $models[] = $model['name'];
                }
            }
            if (empty($models)) {
                return;
            }
        }
        
        $viewData = [
            'models' => $models,
            'moduleName' => $this->gs->config['module']['name'],
        ];
        $this->gs->putFile('Database/Seeds/MainSeeder', view()->file($this->gs->getViewBasePath() . 'database/main_seeder.blade.php', $viewData)->render());
    }   
    
}