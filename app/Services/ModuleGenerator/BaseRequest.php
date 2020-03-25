<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class BaseRequest
 */
class BaseRequest extends Base
{    
    /*
     * @return string
     */
    public function getNamespace(): string
    {
        $namespace = 'App\Modules\\' . $this->gs->config['module']['name'] . '\Http\Requests';
        
        if (!empty($this->model['parentModel'])) {
            $namespace.= '\\' . $this->model['parentModel'];
        }
        $namespace.= '\\' . $this->model['name'];
        
        return $namespace;
    }

    /*
     * @return string
     */
    public function getPermission(): string
    {
        $permission = strtolower($this->gs->config['module']['name']);
        
        if (!empty($this->model['parentModel'])) {
            $permission.= '.' . strtolower($this->model['parentModel']);
        }
        $permission.= '.' . strtolower($this->model['name']);
        
        return $permission;
    }

    /*
     * @return string
     */
    public function getPath(): string
    {
        $path = 'Http/Requests';
        
        if (!empty($this->model['parentModel'])) {
            $path.= '/' . $this->model['parentModel'];
        }
        $path.= '/' . $this->model['name'];
        
        return $path;
    }
}
