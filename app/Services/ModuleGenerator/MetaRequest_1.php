<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class Meta
 */
class MetaRequest extends BaseRequest
{    
    /*
     * @return void
     */
    public function generate(): void
    {
        $viewData = [
            'moduleName' => $this->gs->config['module']['name'],
            'modelName' => $this->getModelName(),
            'model' => $this->model,
            'namespace' => $this->getNamespace(),
            'permission' => $this->getPermission(),
        ];
        
        $this->gs->putFile($this->getPath() . '/MetaRequest', view()->file(
            $this->gs->getViewBasePath() . 'http/requests/meta_request.blade.php', $viewData)->render()
        );
    }    
}
