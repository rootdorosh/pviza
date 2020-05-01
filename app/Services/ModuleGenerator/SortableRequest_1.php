<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class Sortable
 */
class SortableRequest extends BaseRequest
{    
    /*
     * @return void
     */
    public function generate(): void
    {
        if (empty($this->model['parentModel'])) {
            return;
        }
        
        $viewData = [
            'moduleName' => $this->gs->config['module']['name'],
            'modelName' => $this->getModelName(),
            'model' => $this->model,
            'namespace' => $this->getNamespace(),
            'permission' => $this->getPermission(),
        ];
        
        $this->gs->putFile($this->getPath() . '/SortableRequest', view()->file(
            $this->gs->getViewBasePath() . 'http/requests/sortable_request.blade.php', $viewData)->render()
        );
    }    
}
