<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class VueStateForm
 */
class VueStateForm extends Base
{
    /*
     * @return void
     */
    public function generate(): void
    {
        $modelName = $this->getModelName();
                
        $viewData = [
            'model' => $this->model,
            'moduleName' => $this->gs->config['module']['name'],
            'modelName' => $modelName,
            'form' => $this->getForm(),
            'components' => $this->getComponents(),
            'modelAttributes' => $this->getModelAttributes(),
            'hasViewModel' => $this->getHasModelView(),
            'modelViewAttributes' => $this->getModelViewAttributes(),
        ]; 
        
        $this->gs->putVueFile(
            'store/' . Str::camel($this->model['name']) . '/form', 
            'js', 
            view()->file($this->gs->getViewBasePath() . 'vuejs/state/form.blade.php', $viewData)->render()
        );        
    }
    
     /*
     * @return bool
     */
    public function getHasModelView(): bool
    {
        foreach ($this->model['vue']['model'] as $attr => $def) {
            $conf = !empty($this->model['fields'][$attr]) ? $this->model['fields'][$attr] : [];
            if (array_key_exists( 'editable', $conf) && !$conf['editable']) {
                return true;
            }
        }
        return false;
    }   

    /*
     * @return array
     */
    public function getModelViewAttributes(): array
    {
        $data = [];
        foreach ($this->model['vue']['model'] as $attr => $def) {
            $conf = !empty($this->model['fields'][$attr]) ? $this->model['fields'][$attr] : [];
            if (array_key_exists( 'editable', $conf) && !$conf['editable']) {
                $key = $attr;
                
                if (!empty($conf['relation']) && $conf['relation']['type'] === 'BelongsTo') {
                    $relationTitleAttr = $conf['relation']['title_attr'] ?? 'title';
                    $key = Str::before($attr, '_id') . '_' . $relationTitleAttr;
                }
                $data[] = $key;
            }
        }
        return $data;
    }   
    
    /*
     * @return array
     */
    public function getModelAttributes(): array
    {
        $data = ['id' => "''"];
        foreach ($this->model['vue']['model'] as $attr => $def) {
            $conf = !empty($this->model['fields'][$attr]) ? $this->model['fields'][$attr] : [];
            if (array_key_exists('editable', $conf) && $conf['editable']) {
                $data[$attr] = $def;
            }
        }
        return $data;
    }   

    /*
     * @return array
     */
    public function getComponents(): array
    {
        $data = [
            'FormFooter' => '@/components/FormFooter/FormFooter',
            'ImageBase64' => '@/components/FormElements/InputFilePreview/ImageFileBase64',
        ];
        
        if ($this->model['hasBelongsToMany']) {
            $data['SelectMultiple'] = '@/components/Form/SelectMultiple.vue';
        }
        
        if (!empty($this->model['children'])) {
            foreach ($this->model['children'] as $child) {
                $parentModelType = !empty($child['parentModelConf']['widget']) ? $child['parentModelConf']['widget'] : 'listgrid';
                if ($parentModelType === 'listgrid') {
                    $data['ListGrid'] = '@/components/ListGrid/index.vue';
                }
                if ($parentModelType === 'listing') {
                    $data['Listing'] = '@/components/Listing/index.vue';
                }
            }
        }
        if (!empty($this->getAdaptiveImages())) {
            $data['AdaptiveImages'] = '@/components/AdaptiveImages/index.vue';
        }
        
        return $data;
    }
    
    /*
     * @return string
     */
    public function getForm(): string
    {
        $html = self::TAB6 . '<b-tabs content-class="mt-3">' . self::ENTER;
        $html.= self::TAB8 .    '<b-tab :title="$t(\'tab.main\')" :title-link-class="hasErrorsInTabMain() ? \'error\':\'\'" active>' . self::ENTER;          
        
        foreach ($this->model['vue']['form']['fields'] as $attr => $item) {
            $conf = $this->model['fields'][$attr];
            
            if (!empty($conf['uiType']) && in_array($conf['uiType'], ['AdaptiveImage']) || 
                (array_key_exists('editable', $conf) && !$conf['editable'])
            ) {
                continue;
            }
            
            $errorKey = 'errors.' . $attr;        
            
            $html.= self::TAB10 .    '<b-form-group' . self::ENTER;
            $html.= self::TAB12 .       'label-for="' . $attr . '"' . self::ENTER;
            $html.= self::TAB12 .       'horizontal' . self::ENTER;
            if (array_key_exists('required', $conf) && $conf['required']) {
                $html.= self::TAB12 .       'label-class="required"' . self::ENTER;
            }
            $html.= self::TAB12 .       ':label="meta.fields.' . $attr . '"' . self::ENTER;
            $html.= self::TAB12 .       ':description="meta.description.' . $attr . '"' . self::ENTER;
            $html.= self::TAB12 .       ':label-cols="2"' . self::ENTER;
            $html.= self::TAB10 .     '> ' . self::ENTER;
            
            if ($item['type'] === 'numeric') {
                $html.= self::TAB12 .     '<b-form-input' . self::ENTER;
                $html.= self::TAB14 .       'type="number"' . self::ENTER;
                $html.= self::TAB14 .       'id="' . $attr . '"' . self::ENTER;
                $html.= self::TAB14 .       'v-model="model.' . $attr . '"' . self::ENTER;
                
                if (!empty($item['step'])) {
                    $html.= self::TAB14 .   'step="' . $item['step'] . '"' . self::ENTER;
                }
                if (!empty($item['min'])) {
                    $html.= self::TAB14 .   'min="' . $item['min'] . '"' . self::ENTER;
                }
                if (!empty($item['max'])) {
                    $html.= self::TAB14 .   'max="' . $item['max'] . '"' . self::ENTER;
                }
                
                $html.= self::TAB12 .     '/>' . self::ENTER;
                
            } elseif ($item['type'] === 'input') {
                $html.= self::TAB12 .     '<b-form-input' . self::ENTER;
                $html.= self::TAB14 .       'type="text"' . self::ENTER;
                $html.= self::TAB14 .       'id="' . $attr . '"' . self::ENTER;
                $html.= self::TAB14 .       'v-model="model.' . $attr . '"' . self::ENTER;
                $html.= self::TAB12 .     '/>' . self::ENTER;
                
            } elseif ($item['type'] === 'datetime') {
                $html.= self::TAB12 .     '<datetime' . self::ENTER;
                $html.= self::TAB14 .       'type="datetime"' . self::ENTER;
                $html.= self::TAB14 .       'format="yyyy-MM-dd HH:mm:ss"' . self::ENTER;
                $html.= self::TAB14 .       'id="' . $attr . '"' . self::ENTER;
                $html.= self::TAB14 .       'v-model="model.' . $attr . '"' . self::ENTER;
                $html.= self::TAB14 .       ':auto="true"' . self::ENTER;
                $html.= self::TAB12 .     '/>' . self::ENTER;
                
            } elseif ($item['type'] === 'color') {
                $html.= self::TAB12 .     '<b-form-input' . self::ENTER;
                $html.= self::TAB14 .       'type="text"' . self::ENTER;
                $html.= self::TAB14 .       'id="' . $attr . '"' . self::ENTER;
                $html.= self::TAB14 .       'v-model="model.' . $attr . '"' . self::ENTER;
                $html.= self::TAB12 .     '/>' . self::ENTER;
                
            } elseif ($item['type'] === 'multiSelect') {
                
                $html.= self::TAB12 .     '<select-multiple' . self::ENTER;
                $html.= self::TAB14 .     '  :options="meta.options.'.$attr.'"' . self::ENTER;
                $html.= self::TAB14 .     '  v-model="model.'.$attr.'"' . self::ENTER;
                $html.= self::TAB12 .     '/>' . self::ENTER;                
                
            } elseif ($item['type'] === 'checkbox') {          
                $html.= self::TAB12 .     '<b-form-radio-group' . self::ENTER;
                $html.= self::TAB14 .       'id="' . $attr . '"' . self::ENTER;
                $html.= self::TAB14 .       ':options="optionsNoYes"' . self::ENTER;
                $html.= self::TAB14 .       'buttons' . self::ENTER;
                $html.= self::TAB14 .       'button-variant="outline-primary"' . self::ENTER;
                $html.= self::TAB14 .       'v-model="model.' . $attr . '"' . self::ENTER;
                $html.= self::TAB12 .     '/>' . self::ENTER;
                
            } elseif ($item['type'] == 'textarea') {          
                $html.= self::TAB12 .     '<b-form-textarea' . self::ENTER;
                $html.= self::TAB14 .       'id="' . $attr . '"' . self::ENTER;
                $html.= self::TAB14 .       'v-model="model.' . $attr . '"' . self::ENTER;
                $html.= self::TAB12 .     '/>' . self::ENTER;
              
            } elseif ($item['type'] == 'select') {          
                $html.= self::TAB12 .     '<b-form-select' . self::ENTER;
                $html.= self::TAB14 .       'id="' . $attr . '"' . self::ENTER;
                $html.= self::TAB14 .       'v-model="model.' . $attr . '"' . self::ENTER;
                $html.= self::TAB14 .       ':options="meta.options.' . $conf['optionsKey'] . '"' . self::ENTER;
                $html.= self::TAB12 .     '/>' . self::ENTER;
                
            } elseif ($item['type'] == 'ckeditor') {          
                $html.= self::TAB12 .     '<editor' . self::ENTER;
                $html.= self::TAB14 .       'v-model="model.' . $attr . '"' . self::ENTER;
                $html.= self::TAB14 .       'id="' . $attr . '"' . self::ENTER;
                $html.= self::TAB12 .     '/>' . self::ENTER;
             
            } elseif ($item['type'] == 'image') {          
                $html.= self::TAB12 .     '<image-base64 v-model="model.' . $attr . '" />' . "\n";
                
                $errorKey =  "errors['{$attr}.content']";
            }
            $html.= self::TAB12 .         '<span class="text-danger" v-if="' . $errorKey . '">{{ ' . $errorKey . '[0] }}</span>' . self::ENTER;
            $html.= self::TAB10 .       '</b-form-group>' . self::ENTER . self::ENTER;
        }  
        $html.= self::TAB8 .          '</b-tab>' . self::ENTER . self::ENTER;



        if (!empty($this->model['vue']['form']['translatable']['fields'])) {
            $html.= self::ENTER . self::TAB8 . '<b-tab v-for="locale in getLocales()" :title="locale" :title-link-class="hasErrorsInTabLocale(locale) ? \'error\':\'\'">' . self::ENTER;
            
            foreach ($this->model['vue']['form']['translatable']['fields'] as $attr => $item) {
                
                $conf = $this->model['translatable']['fields'][$attr];
                
                $html.= self::TAB10 . '<b-form-group' . self::ENTER;
                $html.= self::TAB12 .   ':label="meta.fields.' . $attr . '"' . self::ENTER;
                $html.= self::TAB12 .   ':label-for="locale + \'-' . $attr . '\'"' . self::ENTER;
                if (array_key_exists('required', $conf) && $conf['required']) {
                    $html.= self::TAB12 .       'label-class="required"' . self::ENTER;
                }
                $html.= self::TAB12 .   ':class="{\'is-invalid\': getErrorLocale(\'' . $attr . '\', locale)}"' . self::ENTER;
                $html.= self::TAB12 .   'label-cols-sm="2"' . self::ENTER;
                $html.= self::TAB10 . '>' . self::ENTER;

                if ($item['type'] === 'input') {
                    $html.= self::TAB12 .   '<b-form-input' . self::ENTER;
                    $html.= self::TAB14 .     'type="text"' . self::ENTER;
                    $html.= self::TAB14 .     ':id="locale + \'-' . $attr . '\'"' . self::ENTER;
                    $html.= self::TAB14 .     'v-model="model[locale].' . $attr . '"' . self::ENTER;
                    $html.= self::TAB12 .   '/>' . self::ENTER;
                
                } elseif ($item['type'] == 'textarea') {          
                    $html.= self::TAB12 .   '<b-form-textarea' . self::ENTER;
                    $html.= self::TAB14 .     ':id="locale + \'-' . $attr . '\'"' . self::ENTER;
                    $html.= self::TAB14 .     'v-model="model[locale].' . $attr . '"' . self::ENTER;
                    $html.= self::TAB12 .   '/>' . self::ENTER;
                    
                } elseif ($item['type'] == 'ckeditor') {          
                    $html.= self::TAB12 .     '<mavon-editor' . self::ENTER;
                    $html.= self::TAB14 .       ':id="locale + \'-' . $attr . '\'"' . self::ENTER;
                    $html.= self::TAB14 .       'v-model="model[locale].' . $attr . '"' . self::ENTER;
                    $html.= self::TAB12 .     '/>' . self::ENTER;
               }
                
                $html.= self::TAB12 .   '<span class="text-danger" v-if="getErrorLocale(\'' . $attr . '\', locale)">{{ getErrorLocale(\'' . $attr . '\', locale) }}</span>' . self::ENTER;
                $html.= self::TAB10 . '</b-form-group>' . self::ENTER . self::ENTER;
            }
            
            $html.= self::TAB8 . '</b-tab>' . self::ENTER;
        }
        
        if (!empty($this->getAdaptiveImages())) {
            foreach ($this->getAdaptiveImages() as $attr => $item) {
                $html.= self::ENTER . self::TAB8 . '<b-tab :title="meta.fields.' . $attr . '">' . "\n";
                
                $html.= self::TAB8 . '  <adaptive-images' . "\n";
                $html.= self::TAB8 . '    model-name="' . Str::kebab($this->model['name']) . '"' . "\n";
                $html.= self::TAB8 . '    attribute-name="' . $attr . '"' . "\n";
                $html.= self::TAB8 . '    v-model="model.' . $attr . '"' . "\n";
                $html.= self::TAB8 . '    :sizes="meta.adaptive_images.' . $attr . '"' . "\n";
                
                
                $html.= self::TAB8 . '  />' . "\n";
                 
                
                $html.= self::TAB8 . '</b-tab>' . "\n";                
            }
        }
         
        if (!empty($this->model['children'])) {
            foreach ($this->model['children'] as $child) {
                $html.= self::ENTER . self::TAB8 . '<b-tab :title="meta.title.' . Str::snake($child['name_plural']) . '"' . "\n";
                $html.= self::TAB8 . '        v-if="model.id"' . "\n";
                $html.= self::TAB8 . '>' . "\n";
                
                $parentModelType = !empty($child['parentModelConf']['widget']) ? $child['parentModelConf']['widget'] : 'listgrid';
                
                if ($parentModelType === 'listgrid') {
                    $html.= self::TAB8 . '  <list-grid' . "\n";
                    $html.= self::TAB8 . '    id="' . Str::kebab($this->model['name']) . '-'. Str::kebab($child['name_plural']) .'"' . "\n";
                    $html.= self::TAB8 . '    :url="\'' . $this->model['base_uri'] . '/\' + model.id + \'/'. Str::kebab($child['name_plural']) .'\'"' . "\n";
                    if (!empty($child['listGrid'])) {
                        foreach ($child['listGrid'] as $k => $v) {
                            $html.= self::TAB8 . '    ' . $k . '="' . $v . '"' . "\n";
                        }
                    }
                    $html.= self::TAB8 . '    permission="' . $child['permission'] . '"' . "\n";
                    $html.= self::TAB8 . '  />' . "\n";
                    
                } elseif ($parentModelType === 'listing') {
                    $html.= self::TAB8 . '  <listing' . "\n";
                    $html.= self::TAB8 . '    id="' . Str::kebab($this->model['name']) . '-'. Str::kebab($child['name_plural']) .'"' . "\n";
                    $html.= self::TAB8 . '    :url="\'' . $this->model['base_uri'] . '/\' + model.id + \'/'. Str::kebab($child['name_plural']) .'\'"' . "\n";
                    $html.= self::TAB8 . '    permission="' . $child['permission'] . '"' . "\n";
                    $html.= self::TAB8 . '  />' . "\n";
                }
                
                $html.= self::TAB8 . '</b-tab>' . "\n";
            }
        }
        
        $html.= self::TAB6 . '</b-tabs>' . self::ENTER;
        
        return $html;
    }   
    
}
