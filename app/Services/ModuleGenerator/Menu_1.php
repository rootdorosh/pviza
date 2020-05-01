<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;
use App\Base\ScmsHelper;

/**
 * class Menu
 */
class Menu extends BaseModule
{
    /*
     * @return void
     */

    public function generate(): void
    {
        $this->put(
            $this->gs->formatArray(
                $this->getData()
            )
        );
    }   

    /*
     * @return array
     */
    protected function getData(): array
    {
        $conf = $this->gs->config['module']['menu'];
        
        $data = [
            'id' => $conf['id'],
            'title' => str_replace('%module%', Str::camel($this->gs->config['module']['name']), $conf['title']),
            'route' => '/' . $conf['route'],
            'icon' => $conf['icon'],
            'permission' => $conf['permission'] . '.index',  
            'right' => false,
            'left' => true,
        ];
        
        foreach ($this->models as $model) {
            if (!empty($model['type'])) {
                continue;
            }
            
            if ($model['name'] !== $conf['id'] && empty($model['parentModel'])) {
                $data['children'][] = $this->getModelData($model);
            }
        }
        
        return [$data];
    }   

    /*
     * @param array $model
     * @return array
     */
    protected function getModelData(array $model): array
    {
        $data = [
            'id' => $model['name'],
            'title' => Str::camel($this->gs->config['module']['name']) .'::'. Str::snake($model['name']) . '.title.index',
            'route' => '/' . $model['base_uri'],
            'icon' => !empty($model['menu']['icon']) ? $model['menu']['icon'] : '',
            'permission' => $model['permission'] . '.index',            
        ];
        
        return $data;
    }   
    
    /*
     * @return void
     */
    protected function createFile(): void
    {
        $data = $this->getModelData();
        
        $this->put($this->formatData($data));
    }   
    
    /*
     * @return void
     */
    protected function updateFile(): void
    {
        $routeFile = $this->getFile();
        
        $data = array_merge_recursive(
            $this->removeModelData($this->parseFile()), 
            $this->getModelData()
        );
        $this->put($this->formatData($data));
    }  
    
    /*
     * @param string $content
     */
    protected function put(string $content): void
    {
        $this->gs->putFile('Config/menu', view()->file(
            $this->gs->getViewBasePath() . 'config/menu.blade.php', compact('content'))->render()
        );
    }
    
    /*
     * @param array $data
     * @return array
     */

    protected function removeModelData(array $data): array
    {
        $modelStates = [];
        foreach (['index', 'form'] as $key) {
            $modelStates[] = $this->model['vue']['stateName'] . ucfirst($key);
        }
        
        foreach ($data as $i => $item) {
            if (in_array($i, $modelStates)) {
                unset($data[$i]);
            }
        }
        
        return $data;
    }
    
    /*
     * @return array
     */
    protected function parseFile(): array
    {
        return include ($this->getFile());
    }   
    
    /*
     * @return string
     */
    protected function getFile(): string
    {
        return $this->gs->getModulePath() . '/Config/menu.php';
    }   
    
}