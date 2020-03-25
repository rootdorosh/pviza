<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class Show
 */
class ShowRequest extends BaseRequest
{    
    /*
     * @return void
     */
    public function generate(): void
    {
        $action = null;
        
        if (empty($this->model['exceptCrud']) || 
            (!empty($this->model['exceptCrud']) && !in_array('update', $this->model['exceptCrud']))
        ) {
            $action = 'update';
        }
        
        if (!empty($this->model['uiView']) && !$action) {
            $action = 'view';
        }
        if (!$action) {
            return;
        }
        
        $viewData = [
            'moduleName' => $this->gs->config['module']['name'],
            'modelName' => $this->getModelName(),
            'model' => $this->model,
            'namespace' => $this->getNamespace(),
            'permission' => $this->getPermission(),
            'action' => $action,
        ];
        
        $this->gs->putFile($this->getPath() . '/ShowRequest', view()->file(
            $this->gs->getViewBasePath() . 'http/requests/show_request.blade.php', $viewData)->render()
        );
    }    
}
