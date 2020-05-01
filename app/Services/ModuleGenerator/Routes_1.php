<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;
use App\Base\ScmsHelper;

/**
 * class Routes
 */
class Routes extends BaseModule
{
    /*
     * @return void
     */

    public function generate(): void
    {
        $this->put(implode("\n", $this->getData()));
    }   

    /*
     * @return array
     */
    protected function getData(): array
    {   
        $data = [];
        foreach ($this->models as $model) {
            if (!empty($model['parentModel']) || !empty($model['type'])) {
                continue;
            }
            
            $parameters = '->parameters([\''.$model['routes']['path'].'\' => \''.Str::camel($model['name']).'\'])';
            
            
            $data[] = "\n";
            $data[] = "\t".'Route::get(\'' . $model['routes']['path'] . '/meta\', \'' . $model['name'] . 'Controller@meta\')->name(\'' . Str::kebab($model['name_plural']) . '.meta\');';
            $data[] = "\t".'Route::delete(\'' . $model['routes']['path'] . '/bulk-destroy\', \'' . $model['name'] . 'Controller@bulkDestroy\')->name(\'' . Str::kebab($model['name_plural']) . '.bulkDestroy\');';
        
            if(isset($model['routes']['update_verb']) && $model['routes']['update_verb'] === 'POST') {
                $data[] = "\t".'Route::post(\''.$model['routes']['path'].'/{'.Str::camel($model['name']).'}\', \''.$model['name'].'Controller@update\')->name(\''.Str::kebab($model['name_plural']).'.update\');';
                
                $excepts = ['update'];
                if (!empty($model['exceptCrud']) && in_array('update', $model['exceptCrud']) && empty($model['uiView'])) {
                    $excepts[] = 'show';
                }
                if (!empty($model['exceptCrud']) && in_array('store', $model['exceptCrud'])) {
                    $excepts[] = 'store';
                }
                
                $data[] = "\t".'Route::apiResource(\''.$model['routes']['path'].'\', \''.$model['name'].'Controller\')' . "\n"
                    . "\t\t" . '$parameters' . "\n"
                    . "\t\t" . '->except(\''. implode("', '", $excepts) .'\');';
            } else {
                
                $excepts = [];
                if (!empty($model['exceptCrud']) && in_array('update', $model['exceptCrud'])) {
                    $excepts[] = 'update';
                    if (empty($model['uiView'])) {
                        $excepts[] = 'show';
                    }
                }
                if (!empty($model['exceptCrud']) && in_array('store', $model['exceptCrud'])) {
                    $excepts[] = 'store';
                }
                if (empty($excepts)) { 
                    $data[] = "\t".'Route::apiResource(\''.$model['routes']['path'].'\', \''.$model['name'].'Controller\')'.$parameters.';';
                } else {
                    $data[] = "\t".'Route::apiResource(\''.$model['routes']['path'].'\', \''.$model['name'].'Controller\')' . "\n"
                        . "\t\t". $parameters . "\n"
                        . "\t\t". '->except(\''. implode("', '", $excepts) .'\');';
                }
            }
            
            $childrenModels = $this->getChildrenModels($model);
            if (!empty($childrenModels)) {
                
                
                
                $data[] = "\n";
                $data[] = "\t" . 'Route::name(\'' . Str::kebab($model['name_plural']) .'.\')';
                $data[] = "\t\t" . '->namespace(\''. $model['name'] .'\')';
                $data[] = "\t\t" . '->prefix(\''. $model['routes']['path'] .'/{'. Str::snake($model['name']) .'}\')';
                $data[] = "\t\t" . '->group(function () {';
                
                foreach ($childrenModels as $child) {
                    $data[] = "\t\t\t".'Route::get(\'' . $child['routes']['path'] . '/meta\', \'' . $child['name'] . 'Controller@meta\')->name(\'' . Str::kebab($child['name_plural']) . '.meta\');';
                    $data[] = "\t\t\t".'Route::put(\'' . $child['routes']['path'] . '/sortable\', \'' . $child['name'] . 'Controller@sortable\')->name(\'' . Str::kebab($child['name_plural']) . '.sortable\');';
                    $data[] = "\t\t\t".'Route::delete(\'' . $child['routes']['path'] . '/bulk-destroy\', \'' . $child['name'] . 'Controller@bulkDestroy\')->name(\'' . Str::kebab($child['name_plural']) . '.bulkDestroy\');';
                    $data[] = "\t\t\t".'Route::apiResource(\''.$child['routes']['path'].'\', \''.$child['name'].'Controller\');';
                }
                $data[] = "\t});";
            }
            
    
        
        
        

            
        }

        return $data;
    }   
            
    /*
     * @param string $content
     */
    protected function put(string $content): void
    {
        $viewData = [
            'content' => $content,
            'moduleName' => $this->gs->config['module']['name'],
        ];
        
        $this->gs->putFile('Http/routes', view()->file(
            $this->gs->getViewBasePath() . 'http/routes.blade.php', $viewData)->render()
        );
    }
        
    /*
     * @return string
     */
    protected function getFile(): string
    {
        return $this->gs->getModulePath() . '/Http/routes.php';
    }   
    
}