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

        foreach ($fields as $key => $item) {
            if ((isset($item['filter']) && $item['filter']) || isset($item['vue']['index']) && $item['vue']['index']) {
                $defaultIncludes[] = $key;
                
                if (!empty($item['relation']) && $item['relation']['type'] === 'BelongsTo') {
                    $relationTitleAttr = $item['relation']['title_attr'] ?? 'title';
                    $defaultIncludes[] = Str::before($key, '_id') . '_' . $relationTitleAttr;
                }
 
            }
            $availableIncludes[] = $key;            
        }

        foreach ($fields as $key => $item) {
            $itemIncludes[] = $key;
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
            } elseif (!empty($item['uiType']) && $item['uiType'] === 'AdaptiveImage') {
                $body = '$data = (array) $'. Str::camel($this->model['name']) .'->'. $attr .';';
                $body.= "\n\t\t\t".'return $this->primitive(array_dot($data));';                
            } elseif (!empty($item['uiType']) && $item['uiType'] === 'datetime') {
                
                $body= 'return $this->primitive(';
                $body.= "\n\t\t\t".'$'. Str::camel($this->model['name']) . '->' . $attr;
                $body.= "\n\t\t\t".'    ? date(config(\'scms.datetime_format\'), $'. Str::camel($this->model['name']) .'->'. $attr .')';
                $body.= "\n\t\t\t".'    : null';
                $body.= "\n\t\t);\n";
                
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
                $relKey = Str::before($attr, '_id') . '_' . $relationTitleAttr;
                
                $items[] = [
                    'attr' => $relKey,
                    'return' => '\League\Fractal\Resource\Item',
                    'body' => 'return $this->primitive($'. Str::camel($this->model['name']) .'->'. $relKey .');',
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
