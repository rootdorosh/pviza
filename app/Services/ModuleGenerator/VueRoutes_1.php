<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class Formatter
 */
class VueRoutes
{
    const ENTER = "\n";
    const TAB2 = '  ';
    const TAB4 = '    ';
    const TAB6 = '      ';
    const TAB8 = '        ';
    const TAB10 = '         ';
    const TAB12 = '           ';
    const TAB14 = '             ';
    const TAB16 = '               ';
    
    /*
     * @param array $model
     * @return array
     */
    public function getData(array $model): array
    {
        $mapUrlEnd = [
            'create' => '/create',
            'update' => '/:id',
            'view' => '/:id/view',
        ];
        
        $data = [];
        foreach ($model['pages'] as $key => $val) {
            if (!$val || in_array($key, ['delete'])) {
                continue;
            }
            
            $name = ucfirst($key);
            $compName = $model['vue']['componentName'] . $name;
            
            $urlEnd = !empty($mapUrlEnd[$key]) ? $mapUrlEnd[$key] : '';
            
            $data['map'][] = [
                'path' => '/' . $model['base_uri'] . $urlEnd,
                'name' => Str::camel($model['vue']['componentName']) . $name,
                'component' => $compName,
            ];
            
            $data['imports'][$compName] = "import " . $compName . " from './views/" . Str::camel($model['name']) . "/{$name}/{$name}'";
        }
        
        return $data;
    }
      
    /*
     * @param array $data
     * @return array
     */
    public function getDataFormatted(array $data): array
    {
        $imports = $data['imports'];
        $map = [];
        
        foreach ($data['map'] as $item) {
            $json = self::TAB2 . "{" . self::ENTER;
            $json.= self::TAB4 .   "path: '" . $item['path'] . "'," . self::ENTER;
            $json.= self::TAB4 .   "name: '" . $item['name'] . "'," . self::ENTER;
            $json.= self::TAB4 .   "component: " . $item['component'] . "," . self::ENTER;
            $json.= self::TAB2 . "}";
            
            $map[] = $json;            
        }
        
        return compact('imports', 'map');
    }
    
}