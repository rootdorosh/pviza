<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class FormRequest
 */
class FormRequest extends BaseRequest
{    
    /*
     * @return void
     */
    public function generate(): void
    {
        if (!empty($this->model['exceptCrud']) && 
            in_array('update', $this->model['exceptCrud']) &&
            in_array('store', $this->model['exceptCrud'])
        ) {
            return;
        }
        
        $viewData = [
            'moduleName' => $this->gs->config['module']['name'],
            'modelName' => $this->getModelName(),
            'model' => $this->model,
            'rules' => $this->getRules(),
            'namespace' => $this->getNamespace(),
            'permission' => $this->getPermission(),
            'modelDotName' => $this->getModelDotName(),
            'paramsForApi' => $this->getParamsForApi(),
            'uses' => $this->getUses(),
        ];
        
        $this->gs->putFile($this->getPath() . '/FormRequest', view()->file(
            $this->gs->getViewBasePath() . 'http/requests/form_request.blade.php', $viewData)->render()
        );
    }
    
    /*
     * @return string
     */
    public function getModelDotName(): string
    {
        $name = $this->model['name'];
        if (!empty($this->model['parentModel'])) {
            $name = $this->model['parentModel'] . '.' . $name;
        }
        
        return $name;        
    }

    /*
     * @return string
     */
    public function getParamsForApi(): string
    {
        $raw = '';
        
        foreach ($this->model['fields'] as $key => $item) {
            if (array_key_exists('noInFormRequest', $item) && $item['noInFormRequest'] === true) {
                continue;
            }
            $type = !empty($item['required']) ? 'required':'optional';
            $raw.= ' * @bodyParam ' . $key . '  ' . $item['type'] . ' ' . $type . '  ' . $item['label'] . "\n";
            
            if ($item['type'] === 'array' && !empty($item['relation'])) {
                $raw.= ' * @bodyParam ' . $key . '.*  integer required id' .  "\n";
            }
            
        }
        if (!empty($this->model['translatable'])) {
            foreach ($this->model['translatable']['fields'] as $key => $item) {
                $type = !empty($item['required']) ? 'required':'optional';
                $raw.= ' * @bodyParam lang[' . $key . ']  ' . $item['type'] . ' ' . $type . '  ' . $item['label'] . "\n";
            }
        }
        
        return $raw;
    }
    
    /*
     * @return array
     */
    public function getUses(): array
    {
        $items = [];
        if (!empty($this->model['imagesAttributes'])) {
            $items[] = 'App\Validators\ImageBase64';
        }
        if (!empty($this->model['adaptiveImagesAttributes'])) {
            $items[] = 'App\Validators\ImageAdaptive';
        }
        
        return $items;
    }
    
    /*
     * @return string
     */
    public function getRules(): string
    {
        $tab6 = "                       ";
        $tab5 = "                    ";
        $tab4 = "                ";
        $tab3 = "            ";
        $tab2 = "        ";
        
        $rules = "{$tab2}\$rules = [\n";
        
        foreach ($this->model['fields'] as $key => $item) {
            if ((array_key_exists('noInFormRequest', $item) && $item['noInFormRequest'] === true) ||
                (array_key_exists('editable', $item) && !$item['editable'])
            ) {
                continue;
            }
            
            $keyField = $item['uiType'] === 'image' ? "{$key}.content" : $key;
            
            $ruleReq = $item['required'] ? 'required':'nullable';
            $rules .= "{$tab3}'{$keyField}' => [\n";
            $rules .= "{$tab4}'{$ruleReq}',\n";
            
            $ruleType = $item['type'] !== 'image' ? $item['type'] : 'string';
            if ($ruleType === 'datetime') {
                //$ruleType = 'date_format:Y-m-d\TH:i:s.0000';
                $ruleType = false;
            }
            
            if ($item['uiType'] === 'AdaptiveImage') {
                $ruleType = 'array';
            }
            
            if ($ruleType) {
                $rules .= "{$tab4}'{$ruleType}',\n";
            }
            if (!empty($item['rules']) && is_array($item['rules'])) {
                foreach ($item['rules'] as $rule) {
                    $rules .= "{$tab4}'{$rule}',\n";
                }
            }
            
            
            if ($item['type'] === 'image') {
                //dd($item);
                if (empty($item['ruleImage'])) {
                    $rules .= "{$tab4}new ImageBase64(),\n";
                } else {
                    $rules .= "{$tab4}new ImageBase64([\n";
                    foreach ($item['ruleImage'] as $ruleImageKey => $values) {
                        if ($ruleImageKey === 'mimes') {
                            $rules .= "{$tab5}'mimes' => [\n";
                            foreach ($values as $val) {
                                $rules .= "{$tab6}'{$val}',\n";
                            }
                            $rules .= "{$tab5}],\n";
                        }
                    }
                    $rules .= "{$tab4}]),\n";
                }
            }
            
            if (!empty($item['uiType']) && $item['uiType'] === 'AdaptiveImage') {
                $rules .= "{$tab4}new ImageAdaptive(),\n";
            }
            
            $rules .= "{$tab3}],\n";
            
            // e.g image_name
            if ($item['uiType'] === 'image') {
                
                $rules .= "{$tab3}'{$key}' => [\n";
                $rules .= "{$tab4}'nullable',\n";
                $rules .= "{$tab3}],\n";   
                
                $rules .= "{$tab3}'{$key}.name' => [\n";
                $rules .= "{$tab4}'nullable',\n";
                $rules .= "{$tab4}'string',\n";
                $rules .= "{$tab3}],\n";                
            }
            
            
            if ($item['type'] === 'array' && !empty($item['relation'])) {
                $rules .= "{$tab3}'{$key}.*' => [\n";
                $rules .= "{$tab4}'required',\n";
                $rules .= "{$tab4}'integer',\n";
                $rules .= "{$tab4}'exists:{$item['relation']['tableBelong']},id',\n";
                $rules .= "{$tab3}],\n";                
            }

            
        }
        $rules .= "{$tab2}];\n";

        if (!empty($this->model['translatable'])){
            $rules .= "\n{$tab2}" . 'foreach (config(\'translatable.locales\') as $locale) {' . "\n";
            foreach ($this->model['translatable']['fields'] as $key => $item){
                $ruleReq = !empty($item['required']) ? 'required':'nullable';
                $rules .= "{$tab3}" . '$rules[$locale.\'.'.$key.'\'] = [' . "\n"; 
                $rules .= "{$tab4}" . "'{$ruleReq}',\n";
                $rules .= "{$tab4}" . "'{$item['type']}',\n";
                if (!empty($item['rules']) && is_array($item['rules'])) {
                    foreach ($item['rules'] as $rule) {
                        $rules .= "{$tab4}'{$rule}',\n";
                    }
                }
                $rules .= "{$tab3}" . "];\n";
            }     
            $rules .= "{$tab2}" . '}';
        }   
        
        $rules .= "\n\n\t\treturn \$rules;";
        
        
        return $rules;
    }
    
}
