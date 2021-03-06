<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class BulkDestroy
 */
class BulkDestroyRequest extends BaseRequest
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
        
        $this->gs->putFile($this->getPath() . '/BulkDestroyRequest', view()->file(
            $this->gs->getViewBasePath() . 'http/requests/bulk_destroy_request.blade.php', $viewData)->render()
        );
    }    
}
