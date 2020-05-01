<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class ResourceLang
 */
class ResourceLang extends Base
{
    /*
     * @return void
     */
    public function generate(): void
    {
        $data = $this->getData();
        
        foreach (config('translatable.locales') as $locale) {            
            $this->gs->putFile($this->getPath($locale), 
                view()->file($this->gs->getViewBasePath() . 'resources/lang.blade.php', ['content' => $this->gs->formatArray($data)])->render());           
        }        
    }
    
    /*
     * @return array
     */
    public function getFields(): array
    {
        $data = $this->model['fields'];
        if (!empty($this->model['translatable'])) {
            $data = array_merge($data, $this->model['translatable']['fields']);
        }
        
        return $data;
    }

    /*
     * @param string $locale
     * @return string
     */
    public function getPath(string $locale): string
    {
        return 'Resources/lang/' . $locale . '/' . Str::snake($this->getModelName());
    }

    /*
     * @return array
     */
    public function getData(): array
    {
        $titles = [
            'singular' => $this->model['name'],
            'creating' => 'Creating ' . $this->model['name'],
            'updating' => 'Updating ' . $this->model['name'],
            'index' => $this->model['name_plural'],
        ];
        
        if (!empty($this->model['children'])) {
            foreach ($this->model['children'] as $child) {
                $titles[Str::snake($child['name_plural'])] = $child['name_plural'];
            }
        }
        
        $data = [
            'title' => $titles,
            'success' => [
                'created' => $this->model['name'] . ' success created',
                'updated' => $this->model['name'] . ' success updated',
                'deleted' => $this->model['name_plural'] . ' success deleted',
            ],
            
        ];
        $data['fields']['id'] = '#';
        
        foreach ($this->getFields() as $attr => $field) {
            $data['fields'][$attr] = !empty($field['label']) ? $field['label'] : Str::studly($attr);
            
            if (!empty($field['relation']) && $field['relation']['type'] === 'BelongsTo')  {   
                $relationTitleAttr = $field['relation']['title_attr'] ?? 'title';
                $relKey = Str::before($attr, '_id') . '_' . $relationTitleAttr;
                $data['fields'][$relKey] = $data['fields'][$attr]; 
            }     
            
            $data['description'][$attr] = !empty($field['description']) ? $field['description'] : '';
            
            if ($field['uiType'] === 'image') {
                //$data['fields'][$attr . '.content'] =  $data['fields'][$attr];
            }
        }
        
        return $data;
    }
}
