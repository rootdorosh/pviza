<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class TestController
 */
class TestController extends Base
{
    /*
     * @return void
     */
    public function generate(): void
    {
        
        
        $modelName = $this->getModelName();
        
        $viewData = [
            'model' => $this->model,
            'moduleName' => $this->getModuleName(),
            'modelName' => $modelName,
            'namespace' => $this->getNamespace(),
            'updateMethod' => $model['routes']['update_verb'] ?? 'PUT',
            'responsePath' => $this->getStorageResponsePath(),
            'group' => $this->getGroup(),
            'parentModelFactory' => $this->getParentModelFactory(),
            'modelFactory' => $this->getModelFactory(),
            'indexFactoryItems' => $this->getIndexFactoryItems(),
            'routeIndex' => $this->getRouteMain(),
            'routeUpdate' => $this->getRouteMain(true),
        ]; 
       
        $this->gs->putFileTest($this->getPath(), 
            view()->file($this->gs->getViewBasePath() . 'tests/api_crud.blade.php', $viewData)->render());
    }
        
    /*
     * @param bool $paramId
     * @return string
     */
    public function getRouteMain(bool $paramId = false): string
    {
        $routes[] = Str::kebab($this->getModuleName());
        
        if (!empty($this->model['parentModel'])) {
            $routes[] = Str::kebab($this->getConfigParentModel()['routes']['path']);
            $routes[] = '\'.' . '$'.Str::camel($this->model['parentModel']).'->id' . '.\'';
        }
        $routes[] = Str::kebab($this->model['name_plural']);
        if ($paramId) {
            $routes[] = '\'.' . '$'.Str::camel($this->model['name']).'->id';
        }
        
        return str_replace('.', ' . ', implode('/', $routes));
    }

    /*
     * @return string
     */
    public function getParentModelFactory(): string
    {
        $value = "";
        if (!empty($this->model['parentModel'])) {
            $value = "\t\t" . '$' . Str::camel($this->model['parentModel']) . ' = factory('. $this->model['parentModel'] .'::class)->create();'."\n";
        }
        
        return $value;
    }

    /*
     * @return string
     */
    public function getModelFactory(): string
    {
        $value = "";
        if (empty($this->model['parentModel'])) {
            $value = "\t\t" . '$' . Str::camel($this->model['name']) . ' = factory('. $this->model['name'] .'::class)->create(); '."\n";
        } else {
            $value = $this->getParentModelFactory();
            $value = "\t\t" . '$'.Str::camel($this->model['name']).' = $'.Str::camel($this->model['parentModel']).'->'.Str::camel($this->model['name_plural']).'()->save(factory('.$this->model['name'].'::class)->make());'."\n";
        }
        
        return $value;
    }

    /*
     * @return string
     */
    public function getIndexFactoryItems(): string
    {
        $value = "";
        if (empty($this->model['parentModel'])) {
            $value = "\t\t" . 'factory('.$this->model['name'].'::class, 3)->create();'."\n";
        } else {
            $value = "\t\t" . '$'.Str::camel($this->model['parentModel']).'->'.Str::camel($this->model['name_plural']).'()->saveMany(factory('.$this->model['name'].'::class, 3)->make());'."\n";
        }
        
        return $value;
    }

    /*
     * @return string
     */
    public function getPath(): string
    {
        $path = '/tests/Feature/Modules/' . $this->getModuleName() . '/Http/Controllers';
        if (!empty($this->model['parentModel'])) {
            $path.= '/' . $this->model['parentModel'];
        }
        
        return $path. '/' . $this->model['name'] . 'ControllerTest';
    }
        
    /*
     * @return string
     */
    public function getNamespace(): string
    {
        $namespace = 'Tests\Feature\Modules\\' . $this->getModelName() . '\Http\Controllers';
        if (!empty($this->model['parentModel'])) {
            $namespace.= '\\' . $this->model['parentModel'];
        }
        
        return $namespace;
    }
        
    /*
     * @return string
     */
    public function getGroup(): string
    {
        $group = [Str::camel($this->getModuleName())];
        if (!empty($this->model['parentModel'])) {
            $group[] = Str::camel($this->model['parentModel']);
        }
        $group[] = Str::camel($this->model['name']);
        
        return implode('.', $group);
    }
        
}
