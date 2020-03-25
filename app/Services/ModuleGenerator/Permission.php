<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;
use App\Base\ScmsHelper;

/**
 * class Permission
 */
class Permission extends BaseModule
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
        $data = [
            'title' => $this->gs->config['module']['name'],
        ];
        foreach ($this->models as $model) {
            if (!empty($model['type'])) {
                continue;
            }
            
            foreach (['index', 'store', 'update', 'destroy'] as $action) {
                
                if (!empty($model['exceptCrud']) && in_array($action, $model['exceptCrud'])) {
                    continue;
                }
                
                $perm = $model['permission'] . '.' . $action;
                $data['items'][Str::camel($model['nameWithParentPrefix'])]['actions'][$perm] = 'permission.' . $action;
            }
            
            if (!empty($model['uiView'])) {
                $action = 'view';
                $perm = $model['permission'] . '.' . $action;
                $data['items'][Str::camel($model['nameWithParentPrefix'])]['actions'][$perm] = 'permission.' . $action;
            }
        }
        return $data;
    }   

            
    /*
     * @param string $content
     */
    protected function put(string $content): void
    {
        $this->gs->putFile('Config/permissions', view()->file(
            $this->gs->getViewBasePath() . 'config/permissions.blade.php', compact('content'))->render()
        );
    }
        
    /*
     * @return string
     */
    protected function getFile(): string
    {
        return $this->gs->getModulePath() . '/Config/permissions.php';
    }   
    
}