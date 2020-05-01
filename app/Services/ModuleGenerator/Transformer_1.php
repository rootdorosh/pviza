<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class Transformer
 */
class Transformer extends Base
{
    /*
     * @return void
     */
    public function generate(): void
    {
        $modelName = $this->getModelName();
        
        $includes = $this->getIncludes();
        
        $viewData = array_merge([
            'model' => $this->model,
            'moduleName' => $this->gs->config['module']['name'],
            'modelName' => $modelName,
            'namespace' => $this->getNamespace(),
            'uses' => $this->getUses(),
            'includesFunction' => $this->getIncludesFunction(),
        ], $includes); 
        
        $this->gs->putFile($this->getPath(), 
            view()->file($this->gs->getViewBasePath() . 'transformers/transformer.blade.php', $viewData)->render());
    }

    /*
     * @return array
     */
    public function getIncludes(): array
    {
        $defaultIncludes = [];
        $availableIncludes = [];
        $itemIncludes = [];

        $fields = $this->model['fields'];
        if (!empty($this->model['translatable'])) {
            $fields = $fields + $this->model['translatable']['fields'];
            $availableIncludes[] = 'lang';
            $itemIncludes[] = 'lang';
        }
        
        $mapItemIncludes = [];
        foreach ($fields as $key => $item) {
            if ((isset($item['filter']) && $item['filter']) || isset($item['vue']['index']) && $item['vue']['index']) {
                
                if (!empty($item['relation']) && $item['relation']['type'] === 'BelongsTo') {
                    $relationTitleAttr = $item['relation']['title_attr'] ?? 'title';
                    $key_rel = Str::before($key, '_id') . '_' . $relationTitleAttr;
                    $defaultIncludes[] = $key_rel;
                    
                    if ($item['editable']) {
                        $defaultIncludes[] = $key;
                    } else {
                        $mapItemIncludes[$key] = $key_rel;
                    }
                    
                } else {
                    $defaultIncludes[] = $key;
                }
 
            }
            $availableIncludes[] = $key;            
        }

        foreach ($fields as $key => $item) {
            $itemIncludes[] = isset($mapItemIncludes[$key]) ? $mapItemIncludes[$key] : $key;
        }
        
        return compact('defaultIncludes', 'availableIncludes', 'itemIncludes');
    }
    
    /*
     * @return array
     */
    public function getIncludesFunction(): array
    {
        $fields = $this->model['fields'];
        if (!empty($this->model['translatable'])) {
            $fields = $fields + $this->model['translatable']['fields'];
        }

        $items = [];
        
        foreach ($fields as $attr => $item) {    
           
            if (!empty($item['uiType']) && $item['uiType'] === 'image') {
                $body = 'return $this->primitive($'. Str::camel($this->model['name']) .'->getThumb(\'' . $attr . '\', 100, 75, \'resize\'));';
            } elseif ($item['type'] === 'datetime') {
                
                $format = !empty($item['fransformer']['format']) ? $item['fransformer']['format'] : 'datetime_to_ui';
                
                $body= 'return $this->primitive(';
                $body.= "\n\t\t\t".'$'. Str::camel($this->model['name']) . '->' . $attr;
                
                if ($format == 'datetime_to_ui') {
                    $body.= "\n\t\t\t\t".'? datetime_to_ui($'. Str::camel($this->model['name']) .'->'. $attr .')';
                } elseif ($format == 'config.scms') {
                    $body.= "\n\t\t\t\t".'? date(config(\'scms.datetime_format\'), $'. Str::camel($this->model['name']) .'->'. $attr .')';
                }
                $body.= "\n\t\t\t\t".': null';     
                $body.= "\n\t\t);\n";
            } elseif (!empty($item['uiType']) && $item['uiType'] === 'AdaptiveImage') {
                $body = '$data = (array) $'. Str::camel($this->model['name']) .'->'. $attr .';';
                $body.= "\n\t\t\t".'return $this->primitive(array_dot($data));';                
            } elseif ($item['type'] === 'array' && !empty($item['relation'])) {
                $body = 'return $this->primitive($'. Str::camel($this->model['name']) .'->'.$item['relation']['name'].'->pluck(\'id\')->toArray());';
            } else {   
                $body = 'return $this->primitive($'. Str::camel($this->model['name']) .'->'. $attr .');';
            }
                   
            $items[] = [
                'attr' => $attr,
                'return' => '\League\Fractal\Resource\Item',
                'body' => $body,
            ];
            
            if (((isset($item['filter']) && $item['filter']) || isset($item['index']) && $item['index']) &&
                !empty($item['relation']) && $item['relation']['type'] === 'BelongsTo'
            ) {
                $relationTitleAttr = $item['relation']['title_attr'] ?? 'title';
                $relAttr = Str::before($attr, '_id') . '_' . $relationTitleAttr;
                $relParam = Str::before($attr, '_id') . '->' . $relationTitleAttr;
                
                $items[] = [
                    'attr' => $relAttr,
                    'return' => '\League\Fractal\Resource\Item',
                    'body' => 'return $this->primitive($'. Str::camel($this->model['name']) .'->'. $relParam .');',
                ];                    
            }
            
        }
        
        if (!empty($this->model['translatable'])) {
            $items[] = [
                'attr' => 'lang',
                'return' => '\League\Fractal\Resource\Collection',
                'body' => 'return $this->collection($'.Str::camel($this->model['name']).'->translations, new '. $this->model['name'] .'LangTransformer);',
            ];            
        }
        
        return $items;
    }
        
    /*
     * @return string
     */
    public function getPath(): string
    {
        $path = 'Transformers';
        
        if (!empty($this->model['parentModel'])) {
            $path.= '/' . $this->model['parentModel'];
        }
        $path.= '/' . $this->model['name'] . 'Transformer';
        
        return $path;
    }
        
    /*
     * @return array
     */
    public function getUses(): array
    {
        $data = [];
        
        $basePath = 'App\Modules\\' . $this->gs->config['module']['name'];
        $modelPath = $basePath . '\Models';
        if (!empty($this->model['parentModel'])) {
            $modelPath.= '\\' . $this->model['parentModel'];
        }
        $data[] = $modelPath . '\\' . $this->model['name'];
        
        if (!empty($this->model['translatable'])) {
            $langTransformerPath = $basePath . '\\Transformers';
            if (!empty($this->model['parentModel'])) {
                $langTransformerPath.= '\\' . $this->model['parentModel'];
            }
            $data[] = $langTransformerPath . '\\Lang\\' . $this->model['name'] . 'LangTransformer';
        }
      
        return $data;
    }
        
    /*
     * @return string
     */
    public function getNamespace(): string
    {
        $namespace = 'App\Modules\\' . $this->gs->config['module']['name'] . '\Transformers';
        
        if (!empty($this->model['parentModel'])) {
            $namespace.= '\\' . $this->model['parentModel'];
        }
        
        return $namespace;
    }
    
}
