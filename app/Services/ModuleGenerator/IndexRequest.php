<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class IndexRequest
 */
class IndexRequest extends BaseRequest
{    
    /*
     * @return void
     */
    public function generate(): void
    {
        $data = $this->getData();
        
        $viewData = array_merge($data, [
            'moduleName' => $this->gs->config['module']['name'],
            'modelName' => $this->getModelName(),
            'model' => $this->model,
            'rules' => $this->getRules(),
            'namespace' => $this->getNamespace(),
            'permission' => $this->getPermission(),
            'namespaceModels' => $this->getNamespaceModels(),
            'query' => $this->getQuery(),
        ]);
        
        $this->gs->putFile($this->getPath() . '/IndexRequest', view()->file(
            $this->gs->getViewBasePath() . 'http/requests/index_request.blade.php', $viewData)->render()
        );
    }

    /*
     * @return array
     */
    public function getData(): array
    {
        $bodyParams = [
            ['page', 'integer', 'optional', 'page'],
            ['per_page', 'integer', 'optional', 'per page'],
            ['sort_dir', 'string', 'optional', 'sorting dir'],
            ['sort_attr', 'string', 'optional', 'sorting attribute'],
            ['id', 'integer', 'optional', 'id'],
        ];
        $sortAttrs = ['id'];
        
        foreach ($this->model['fields'] as $key => $item) {
            if (isset($item['filter']) && $item['filter']) {
                
                if (!empty($item['relation']) && $item['relation']['type'] === 'BelongsTo') {
                    $relationTitleAttr = $item['relation']['title_attr'] ?? 'title';
                    $relKey = Str::before($key, '_id') . '_' . $relationTitleAttr;
                    $sortAttrs[] = $relKey;
                    $bodyParams[] = [$relKey, 'string', 'optional', $item['label']];
                } else {
                    $bodyParams[] = [$key, $item['type'], 'optional', $item['label']];
                    $sortAttrs[] = $key;
                }
            }
        }
        if (!empty($this->model['translatable'])) {
            foreach ($this->model['translatable']['fields'] as $key => $item) {
                if (isset($item['filter']) && $item['filter']) {
                    $bodyParams[] = [$key, $item['type'], 'optional', $item['label']];
                    $sortAttrs[] = $key;
                }
            }
        }
        
        return compact('bodyParams', 'sortAttrs');
    }
        
    /*
     * @return string
     */
    public function getQuery(): string
    {
        $tab5 = "                    ";
        $tab4 = "                ";
        $tab3 = "            ";
        $tab2 = "        ";
        
        $whereFilter = '';
        $select = [$this->model['table'].'.*'];
        $leftJoin = [];
        $whereLocale = [];
        
        $fields = $this->model['fields'];
        if (!empty($this->model['translatable'])) {
            $fields = $fields + $this->model['translatable']['fields'];
        }
        
        if (!empty($this->model['translatable'])) {
            foreach ($this->model['translatable']['fields'] as $key => $item) {
                if (isset($item['filter']) && $item['filter']) {
                    $select[] = "{$this->model['table']}_lang.{$key} AS {$key}";
                }
            }
            $leftJoin[] = "->leftJoin('{$this->model['table']}_lang', '{$this->model['table']}_lang.{$this->model['translatable']['owner_id']}', '{$this->model['table']}.id')";
            $whereLocale[] = "where('{$this->model['table']}_lang.locale', app()->getLocale())";
        } 

        $whereFilter.=  "\n{$tab2}" . 'if ($this->id !== null) {' . "\n";
        $whereFilter.= $tab3 . '$query->where("'.$this->model['table'].'.id", "like", "%{$this->id}%");' . "\n";
        $whereFilter.= $tab2 . '}' . "\n";
        
        foreach ($fields as $key => $item) {
            if (isset($item['filter']) && $item['filter']) {
                    
                if (!empty($item['relation']) && $item['relation']['type'] === 'BelongsTo')  {   
                    $relationTitleAttr = $item['relation']['title_attr'] ?? 'title';
                    $relKey = Str::before($key, '_id') . '_' . $relationTitleAttr;
                    $relationModel = $item['relation']['info'];

                    $leftJoin[] = "->leftJoin('".$relationModel['table']."', '".$relationModel['table'].".id', '".$this->model['table'].".".$key."')";

                    $whereFilter.=  "\n{$tab2}" . 'if ($this->' . $relKey . ' !== null) {' . "\n";
                        
                    if (!empty($relationModel['translatable'])) {
                        $leftJoin[] = "->leftJoin('".$relationModel['table']."_lang', '".$relationModel['table']."_lang.".$key."', '".$relationModel['table'].".id')";
                        $whereLocale[] = "where('".$relationModel['table']."_lang.locale', app()->getLocale())";
                        //$whereFilter.= $tab3 . '$query->where("' . $relationModel['table'] . '_lang.'.$relationTitleAttr.'", "like", "%{$this->' . $relKey . '}%");' . "\n";    
                    
                        $select[] = "{$relationModel['table']}_lang.{$relationTitleAttr} AS ". Str::snake($relationModel['name']) ."_{$relationTitleAttr}";
                        
                    } else {
                        $select[] = "{$relationModel['table']}.{$relationTitleAttr} AS {$relKey}";
                    }
                    
                    $whereFilter.= $tab3 . '$query->where("' . $relationModel['table'] . '.id" , $this->' . $relKey . ');' . "\n";    
                   
                    $whereFilter.= $tab2 . '}' . "\n";
                } else {
                    $whereFilter.=  "\n{$tab2}" . 'if ($this->' . $key . ' !== null) {' . "\n";
                    
                    $table = $this->model['table'];
                    if (empty($this->model['fields'][$key])) {
                        $table .= '_lang';
                    }
                    
                    $whereFilter.= $tab3 . '$query->where("' . $table . '.' . $key . '", "like", "%{$this->' . $key . '}%");' . "\n";
                    $whereFilter.= $tab2 . '}' . "\n";
                }
            }    
        }
        
        $query = "\t\t\$query = " . $this->model['name'] . "::select([\n"; 
        $query.= "\t\t\t" . implode(",\n\t\t\t", array_map(function($value){ return "'$value'"; }, $select)) . "\n";
        $query.= "\t\t])\n"; 
        $query.= "\t\t\t" . implode("\n\t\t\t", array_map(function($value){ return "$value"; }, $leftJoin)) . ";\n"; 
        
        if (!empty($whereLocale)) {
            $query.= "\n\t\t\$query->" . implode("\n\t\t\t->", array_map(function($value){ return "$value"; }, $whereLocale)) . ";\n";            
        }
        
        $query.= "\n" . $whereFilter;
        
        return $query; 
    }
    
    /*
     * @return string
     */
    public function getRules(): string
    {
        $fields = $this->model['fields'];
        if (!empty($this->model['translatable'])) {
            $fields = $fields + $this->model['translatable']['fields'];
        }

        $tab5 = "                    ";
        $tab4 = "                ";
        $tab3 = "            ";
        $tab2 = "        ";
        
        $rules = "'id' => [\n";
        $rules .= "{$tab4}'nullable',\n";
        $rules .= "{$tab4}'integer',\n";
        $rules .= "{$tab3}],\n";    
        
        foreach ($fields as $key => $item) {

            if (!empty($item['relation']) && $item['relation']['type'] === 'BelongsTo') {
                $relationTitleAttr = $item['relation']['title_attr'] ?? 'title';
                $relKey = Str::before($key, '_id') . '_' . $relationTitleAttr;
                
                $rules .= "{$tab3}'{$relKey}' => [\n";
                $rules .= "{$tab4}'nullable',\n";
                $rules .= "{$tab3}],\n";    
                
                continue;
            }    
            
            $keyField = $item['uiType'] === 'image' ? "{$key}_base64" : $key;
            
            $rules .= "{$tab3}'{$keyField}' => [\n";
            $rules .= "{$tab4}'nullable',\n";
            $ruleType = $item['type'] !== 'image' ? $item['type'] : 'string';
            if ($ruleType === 'integer') {
                $rules .= "{$tab4}'{$ruleType}',\n";
            }
            if (!empty($item['rules']) && is_array($item['rules'])) {
                foreach ($item['rules'] as $rule) {
                    $rules .= "{$tab4}'{$rule}',\n";
                }
            }
            $rules .= "{$tab3}],\n";
            
            // e.g image_name
            if ($item['uiType'] === 'image') {
                $rules .= "{$tab3}'{$key}_name' => [\n";
                $rules .= "{$tab4}'nullable',\n";
                $rules .= "{$tab4}'string',\n";
                $rules .= "{$tab3}],\n";                
            }
        }
        
        return $rules;
    }
    
}
