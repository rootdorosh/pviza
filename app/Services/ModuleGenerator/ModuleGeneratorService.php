<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;
use Exception;
use Cache;
use App\Base\ScmsHelper;

/**
 * class ModuleGeneratorService
 */
class ModuleGeneratorService
{
    /*
     * @var string
     */
    private $module;
    
    /*
     * @var bool
     */
    private $force;
    
    /*
     * @var array
     */
    public $config;
    
    /*
     * ModuleGeneratorService constructor
     * 
     * @param string $module
     * @param bool $force
     * @return void
     */
    public function __construct(string $module, bool $force = false)
    {
        $this->module = $module;
        $this->force = $force;
        $this->config['module'] = require $this->getResourceFileConfig();
    }
    
    /*
     * Run generator
     * 
     * @return void
     */
    public function run(): void
    {
        if (!is_file($this->getResourceFileConfig())) {
            throw new Exception("File {$this->getResourceFileConfig()} not found");
        }
        if (!is_dir($this->getResourcePathModels())) {
            throw new Exception("Directory {$this->getResourcePathModels()} not found");
        }
        
        if (is_dir($this->getModulePath()) && !$this->force) {
            dd("Module {$this->config['module']['name']} already exists, run command with --force option");
        }        
        
        if (!is_dir($this->getModulePath())) {
            mkdir($this->getModulePath());
        }
        
        foreach ($this->getResourceFilesModels() as $modelFile) {
            $confModel = $this->getExrendedModelConfig(require $this->getResourcePathModels() . $modelFile);
            
            $this->config['models'][] = $confModel;
        }
        
        $this->generate();
    }
    
    /*
     * @return void
     */
    public function generate(): void
    {
        // delete migration if exists
        //(new Migration($this))->drop();
        
        $models = [];
        foreach ($this->config['models'] as $modelConfig) {
            if (empty($modelConfig['type']) || (!empty($modelConfig['type']) && $modelConfig['type'] !== 'pivot')) {
                $models[] = $modelConfig['name'];
            }
        }

        $viewData = [
            'models' => $models,
            'moduleName' => $this->config['module']['name'],
            'modelsData' => $this->config['models'],
        ];
        
        foreach ($this->config['models'] as $modelConfig) {
            $this->generateModel($modelConfig);
        }
        (new MainSeeder($this, $this->config['models']))->generate();
        (new Routes($this, $this->config['models']))->generate();
        (new Menu($this, $this->config['models']))->generate();
        (new Permission($this, $this->config['models']))->generate();
        Cache::tags(ScmsHelper::TAG)->flush();
        (new Vue($this))->sync();
    }
    
    /*
     * @param array $modelConfig
     */
    public function generateModel(array $modelConfig) 
    {
        if (!empty($modelConfig['type']) && $modelConfig['type'] === 'pivot') {
            (new MigrationItem($this, $modelConfig))->generate();
            return;
        }
        
        
        if (!empty($modelConfig['skip']) && in_array('*', $modelConfig['skip'])) {
            return;
        }
        
        $viewData = [
            'model' => $modelConfig,
            'moduleName' => $this->config['module']['name'],
            'modelsData' => $this->config['models'],
        ];
        
        (new FormRequest($this, $modelConfig))->generate();        
        (new SortableRequest($this, $modelConfig))->generate();        
        (new MetaRequest($this, $modelConfig))->generate();
        (new IndexRequest($this, $modelConfig))->generate();
        (new ShowRequest($this, $modelConfig))->generate();
        (new DestroyRequest($this, $modelConfig))->generate();
        (new BulkDestroyRequest($this, $modelConfig))->generate();
        
        if ($this->allow('controller', $modelConfig)) { (new Controller($this, $modelConfig))->generate();}
        
        if ($this->allow('serviceFetch', $modelConfig)) { (new ServiceFetch($this, $modelConfig))->generate();}
        if ($this->allow('serviceCrud', $modelConfig)) { (new ServiceCrud($this, $modelConfig))->generate();}
        
        
        if ($this->allow('transformer', $modelConfig)) {
            (new Transformer($this, $modelConfig))->generate();
            
            if (!empty($modelConfig['translatable'])) {
                (new TransformerLang($this, $modelConfig))->generate();
            }
        }
        if ($this->allow('model', $modelConfig)) {
            (new Model($this, $modelConfig))->generate();
            if (!empty($modelConfig['translatable'])) {
                (new ModelLang($this, $modelConfig))->generate();
            }
        }
        
        if ($this->allow('migration', $modelConfig)) {
            (new MigrationItem($this, $modelConfig))->generate();
            if (!empty($modelConfig['translatable'])) {
                (new MigrationItemLang($this, $modelConfig))->generate();
            }
        }
        
        (new Factory($this, $modelConfig))->generate();
        (new Seeder($this, $modelConfig))->generate();
        
        (new ResourceLang($this, $modelConfig))->generate();
        (new TestController($this, $modelConfig))->generate();

        // vue files    
        if (empty($modelConfig['parentModel'])) {
            
            if ($modelConfig['uiStore'] || $modelConfig['uiUpdate']) {
                $this->putVueFile('store/' . Str::camel($modelConfig['name']) . '/form', 'js', view()->file($this->getViewBasePath() . 'vuejs/state/form.blade.php', $viewData)->render());
                (new VueForm($this, $modelConfig))->generate();
            }
            
            if (!empty($modelConfig['uiView'])) {
                $this->putVueFile('store/' . Str::camel($modelConfig['name']) . '/view', 'js', view()->file($this->getViewBasePath() . 'vuejs/state/view.blade.php', $viewData)->render());
                (new VueForm($this, $modelConfig))->generate();
            }
            
            
            if ($this->allow('index.js', $modelConfig)) {
                $this->putVueFile('store/' . Str::camel($modelConfig['name']) . '/index', 'js', view()->file($this->getViewBasePath() . 'vuejs/state/index.blade.php', $viewData)->render());
            }
            if ($modelConfig['uiStore']) {
                $this->putVueFile('views/' . Str::camel($modelConfig['name']) . '/Create/Create', 'vue', view()->file($this->getViewBasePath() . 'vuejs/views/create.blade.php', $viewData)->render());
            }
            if ($modelConfig['uiUpdate']) {
                $this->putVueFile('views/' . Str::camel($modelConfig['name']) . '/Update/Update', 'vue', view()->file($this->getViewBasePath() . 'vuejs/views/update.blade.php', $viewData)->render());
            }
            if ($this->allow('Index.vue', $modelConfig)) {
                $this->putVueFile('views/' . Str::camel($modelConfig['name']) . '/Index/Index', 'vue', view()->file($this->getViewBasePath() . 'vuejs/views/index.blade.php', $viewData)->render());
            }
            
            (new VueModuleRoutes($this, $modelConfig))->generate();
            (new VueModuleStoreMap($this, $modelConfig))->generate(); 
        }
    }
    
    /*
     * @param array $items
     * @param string $delimeter
     * @return array
     */
    public function getValueFromKeyVal(array $items, string $delimeter = ' '): array
    {
        $data = [];
        foreach ($items as $k => $v) {
            $data[] = sprintf('%s%s%s', $k, $delimeter, $v);
        }
        return $data;
    }
        
    /*
     * @param string $file
     * @param array $model
     * @param bool
     */
    public function allow(string $file, array $model): bool
    {
        return empty($model['skip']) ||
               (!empty($model['skip']) && !in_array($file, $model['skip']));
    }    
    
    /*
     * @param array $model
     * @param array
     */
    public function getExrendedModelConfig(array $model): array
    {
        if (isset($model['type']) && $model['type'] === 'pivot') {
            return $model;
        }
        
        //children models
        $path = resource_path() . '/modules/' . Str::camel($this->config['module']['name']) . '/models/*';
        $files = glob($path);
        
        $data = [];
        foreach ($files as $file) {
            $conf = require($file);
            if (!empty($conf['parentModel']) && $conf['parentModel'] === $model['name']) {
                $data[$conf['name']] = $this->getExrendedModelConfig($conf);
            }
        }
        $model['children'] = $data;
        $model['uiStore'] = !(!empty($model['exceptCrud']) && in_array('store', $model['exceptCrud']));
        $model['uiUpdate'] = !(!empty($model['exceptCrud']) && in_array('update', $model['exceptCrud']));
        
        
        $model = $this->extendFields($model);
        
        $model['module'] = $this->config['module'];
        
        $imagesAttributes = [];
        $adaptiveImagesAttributes = [];
        foreach ($model['fields'] as $attr => $item) {
            if (!empty($item['type']) && $item['type'] === 'image') {
                $imagesAttributes[] = $attr;
            }
            if (!empty($item['uiType']) && $item['uiType'] === 'AdaptiveImage') {
                $adaptiveImagesAttributes[] = $attr;
            }
        }
        if (!empty($model['translatable'])) {
            foreach ($model['translatable']['fields'] as $attr => $item) {
                if (!empty($item['type']) && $item['type'] === 'image') {
                    $imagesAttributes[] = 'locale.' . $attr;
                }
                if (!empty($item['uiType']) && $item['uiType'] === 'AdaptiveImage') {
                    $adaptiveImagesAttributes[] = 'locale.' . $attr;
                }
            }
        }
        
        ////////////////////////////////////////////////////////////////////////
        $usePath = 'App\Modules\\' . $this->config['module']['name'] . '\\Models';
        if (!empty($model['parentModel'])) {
            $usePath.= '\\' . $model['parentModel'];
        }
        $usePath.= '\\' . $model['name'];
        $model['usePath'] = $usePath;
        
        ////////////////////////////////////////////////////////////////////////
        $model['nameWithParentPrefix'] = !empty($model['parentModel']) ? $model['parentModel'] . $model['name'] : $model['name'];
        
        
        $model['imagesAttributes'] = $imagesAttributes;
        $model['adaptiveImagesAttributes'] = $adaptiveImagesAttributes;
        $model['hasMedia'] = !empty($imagesAttributes) || !empty($adaptiveImagesAttributes);
        
        if (!empty($model['imagesAttributes'])) {
            $model['depedencies']['services']['crud'][] = 'App\Services\Image\ImageService';
            $model['depedencies']['model'][] = 'App\Services\Image\Thumbnailable';
        }
        if (!empty($model['translatable'])) {
            $model['depedencies']['model'][] = 'App\Services\Translatable\Translatable';            
        }
        $model['depedencies']['model'][] = 'App\Base\Traits\Cacheable';
        $model['depedencies']['model'][] = 'App\Base\Traits\Logable';
        
        $model['depedenciesShort']['model'] = array_map(function($value) {
            return Str::afterLast($value, '\\');
        }, $model['depedencies']['model']);
        
        $model['vue']['model'] = $this->getVueModel($model);
        $model['vue']['filter'] = $this->getVueFilter($model);
        $model['vue']['form'] = $this->getVueFormFields($model);
        $model['vue']['stateName'] = Str::camel($this->config['module']['name']) . $model['name'];
        $model['vue']['componentName'] = Str::studly($this->config['module']['name']) . $model['name'];
        
        $model['permission'] = empty($model['parentModel'])
            ? strtolower($this->config['module']['name']) . '.'. strtolower($model['name'])
            : strtolower($this->config['module']['name']) . '.'. strtolower($model['parentModel']) . '.' .strtolower($model['name']);
        
        $model['base_uri'] = Str::kebab($this->config['module']['name']) . '/' . Str::kebab($model['routes']['path']);
        
        
        foreach (['index', 'create', 'update', 'delete'] as $key) {
            $model['pages'][$key] = empty($model['pageMap']) || in_array($key, $model['pageMap']);
        }
        if (!$model['uiStore']) {
            $model['pages']['create'] = false;
        }
        if (!$model['uiUpdate']) {
            $model['pages']['update'] = false;
        }
       
        $model['pages']['view'] = !empty($model['uiView']) ? true : false;
        
        
        return $model;
    }
    
    /*
     * @param array $model
     * @return array
     */
    public function getVueFormFields(array $model): array
    {
        $data = [];
        
        foreach ($model['fields'] as $attr => $item) {
 
            $data['fields'][$attr] = [
                'type' => $this->getFormFieldType($item),
            ];
        }
       
        if (!empty($model['translatable']['fields'])) {
            foreach ($model['translatable']['fields'] as $attr => $item) {
                $data['translatable']['fields'][$attr] = [
                    'type' => $this->getFormFieldType($item),
                ];
            }
        }
        
        return $data;
    }
    
    /*
     * @param array $model
     * @return array
     */
    public function extendFields(array $model): array
    {
        $model['hasBelongsToMany'] = false;
            
        foreach ($model['fields'] as $attr => $item) {
            
            $model['fields'][$attr]['fillable'] = true;
            
            if (!empty($item['type']) && in_array($item['type'], ['array'])) {
                $model['fields'][$attr]['fillable'] = false;
            }
            
            if (!empty($item['type']) && $item['type'] === 'array') {
                $model['hasBelongsToMany'] = true;
            }
            
 
            $model['fields'][$attr]['uiType'] = $this->getFormFieldType($item);
            
            if (!empty($item['relation']) && $item['relation']['type'] === 'BelongsTo') {
               
                $relationModel = Str::camel(Str::afterLast($item['relation']['model'], '\\'));
                
                $relationModelModule = !empty($item['module']) ? $item['module'] : $this->config['module']['name'];
                
                $file = resource_path() . '/modules/' . Str::camel($relationModelModule) . '/models/' . $relationModel . '.php';
                $model['fields'][$attr]['relation']['info'] = require $file;
            }
        }
       
        if (!empty($model['translatable']['fields'])) {
            foreach ($model['translatable']['fields'] as $attr => $item) {
                $model['translatable']['fields'][$attr]['uiType'] = $this->getFormFieldType($item);
            }
        }
        return $model;
    }
    
    /*
     * @param array $field
     * @return string
     */
    public function getFormFieldType(array $field): string
    {
        if (!empty($field['uiType'])) {
            return $field['uiType'];
        }
        
        $type = 'input';

        // image
        if (!empty($field['type']) && $field['type'] === 'image') {
            $type = 'image';
        // checkbox    
        } elseif (!empty($field['type']) && $field['type'] === 'integer' && !empty($field['rules']) && in_array('in:0,1', $field['rules'])) {
            $type = 'checkbox';
        // textarea    
        } elseif (!empty($field['migration']['type']) && in_array($field['migration']['type'], ['text'])) {
            $type = 'textarea';
        // ckeditor    
        } elseif (!empty($field['migration']['type']) && in_array($field['migration']['type'], ['longText', 'mediumText'])) {
            $type = 'ckeditor'; 
        }
        
        return $type;
    }   
    
    /*
     * @param array $model
     * @return array
     */
    public function getVueFilter(array $model): array
    {
        $data = ['id' => []];
        $fields = $model['fields'];
        if (!empty($model['translatable'])) {
            $fields = array_merge($fields, $model['translatable']['fields']);
        }
        
        foreach ($fields as $attr => $item) {
            if (!empty($item['filter'])|| !empty($item['vue']['index'])) {
                $options = [];
                
                $filterable = (!array_key_exists('filterable', $item) || $item['filterable'] === true) ? true : false;
                
                $key = !empty($item['indexFiled']) ? $item['indexFiled']['name'] : $attr;
                if (!empty($item['indexFiled'])) {
                    $options['indexFiled'] = $item['indexFiled'];
                }
                
                // relation field
                if (!empty($item['relation']) && $item['relation']['type'] === 'BelongsTo')  {  
                    $options['filterable'] = 'select';
                    $options['optionsKey'] = $item['optionsKey'];
                    $relationTitleAttr = $item['relation']['title_attr'] ?? 'title';
                    $key = Str::before($key, '_id') . '_' . $relationTitleAttr;
                 
                // image
                } elseif (!empty($item['type']) && $item['type'] === 'image') {
                    $options['renderable'] = 'image';
                    $options['filterable'] = false;
                    $options['sortable'] = false;

                // color
                } elseif ($item['uiType'] === 'color') {
                    $options['renderable'] = 'color';
                    $options['filterable'] = $filterable;
                    $options['sortable'] = false;
                    
                // select
                } elseif (!empty($item['uiType']) && $item['uiType'] === 'select') {
                    //$options['filterable'] = 'TableHelper.methods.optionFromValueTextToIdText(meta.options.categories)';
                    $options['sortable'] = false;
                
                // checkbox    
                } elseif (!empty($item['type']) && $item['type'] === 'integer' && !empty($item['rules']) && in_array('in:0,1', $item['rules'])) {
                    $options['renderable'] = 'checkbox';
                    $options['filterable'] = 'TableHelper.methods.tableOptionsNoYes()';
                } else {
                    $options['filterable'] = $filterable;
                }
                
                $data[$key] = $options;
            }
        }
        
        return $data;
    }
        
    /*
     * @param array $model
     * @return array
     */
    public function getVueModel(array $model): array
    {
        $attrs = ['id' => "''"];
        foreach ($model['fields'] as $attr => $item) {
            $default = '';
            if (!empty($item['migration']) && array_key_exists('default', $item['migration'])) {
                //$default = $item['migration']['default'];
            }
            
            $attrs[$attr] = "''";
            if (!empty($item['type']) && $item['type'] === 'image') {
                $attrs[$attr . '_name'] = "''";
            } elseif (!empty($item['type']) && $item['type'] === 'array') {
                $attrs[$attr] = '[]';
            }
            
            
        }
        return $attrs;
    }
    
    /*
     * @param string $file
     * @param string $ext
     * @param string $contentg
     * @return void
     */
    public function putVueFile(string $file, string $ext, string $content): void
    {
        $path = $this->getVueModulePath();
        if (!is_dir($path)) {
            mkdir($path);
        }
        
        $folders = explode('/', $file);
        $file = array_pop($folders) . '.' . $ext;
        
        foreach ($folders as $folder) {
            $path .= $folder . DIRECTORY_SEPARATOR;
            if (!is_dir($path)) {
                mkdir($path, 0775);
            }
        }     
        
        $filePath = $path . $file;
        echo "$filePath \n";
        
        file_put_contents($filePath, $content);
    }

    /*
     * @param string $file
     * @param string $content
     * @return void
     */
    public function putFile(string $file, string $content): void
    {
        $content = "<?php \n\n" . $content;
        
        $path = $this->getModulePath();

        $folders = explode('/', $file);
        $file = array_pop($folders) . '.php';
        
        foreach ($folders as $folder) {
            $path .= $folder . DIRECTORY_SEPARATOR;
            if (!is_dir($path)) {
                mkdir($path, 0775);
            }
        }     
        
        $filePath = $path . $file;
        echo "$filePath \n";
        
        file_put_contents($filePath, $content);
    }

    /*
     * @param string $file
     * @param string $content
     * @return void
     */
    public function putFileTest(string $file, string $content): void
    {
        $content = "<?php \n\n" . $content;
        
        $path = base_path() . '/';
        
        $folders = explode('/', $file);
        $file = array_pop($folders) . '.php';
        
        foreach ($folders as $folder) {
            if (empty($folder)) {
                continue;
            }
            $path .= $folder . DIRECTORY_SEPARATOR;
            if (!is_dir($path)) {
                mkdir($path, 0775);
            }
        }     
        
        $filePath = $path . $file;
        echo "$filePath \n";
        
        file_put_contents($filePath, $content);
    }
    
    /*
     * @return string
     */
    public function getPathTestModule(): string
    {
        return base_path() . '/tests/Feature/Modules/' . $this->config['module']['name'];
    }
    

    /*
     * @return string
     */
    public function getViewBasePath(): string
    {
        return app_path() . '/Services/ModuleGenerator/resources/views/';
    }

    /*
     * @return string
     */
    public function getModulePath(): string
    {
        return app_path() . '/Modules/' . $this->config['module']['name'] . '/';
    }
    
    /*
     * @return string
     */
    public function getMigratePath(): string
    {
        return $this->getModulePath() . 'Database/migrations';
    }
    
    /*
     * @return string
     */
    public function getVueModulePath(): string
    {
        return resource_path() . '/scms/src/modules/' . Str::camel($this->config['module']['name']) . '/';
    }
    
    /*
     * @return string
     */
    public function getResourcePath(): string
    {
        return resource_path() . '/modules/' . $this->module . '/';
    }
    
    /*
     * @return string
     */
    public function getResourceFileConfig(): string
    {
        return $this->getResourcePath() . 'conf.php';
    }
    
    /*
     * @return string
     */
    public function getResourcePathModels(): string
    {
        return $this->getResourcePath() . 'models/';
    }
    
    /*
     * @return array
     */
    public function getResourceFilesModels(): array
    {
        $items = [];
        
        $skip = ['.', '..'];
        $files = scandir($this->getResourcePathModels());
        foreach ($files as $file) {
            if (!in_array($file, $skip) && is_file($this->getResourcePathModels() . $file)) {
                $items[] = $file;
            }
        }
        
        $gs = $this;
        usort($items, function ($a, $b) use ($gs) {
            $x = (int) (require $gs->getResourcePathModels() . $a)['id'];
            $y = (int) (require $gs->getResourcePathModels() . $b)['id'];
           
            if ($x == $y) {
                return 0;
            } else if ($x > $y) {
                return 1;
            } else {
                return -1;
            }
        });
        return $items;        
    }   
    
    //HELPERS
    /*
     * @param array $model
     */
    public static function model_const(array $model)
    {
        if (empty($model['consts'])) {
            return '';
        }
        
        $items = [];
        
        foreach ($model['consts'] as $name => $data) {
            $items[] = '';
            foreach ($data['items'] as $i => $item) {
                $items[] = "\tCONST " . $name . '_' . strtoupper($item) . ' = ' . ($i+1) . ';';
            }
            $items[] = "\tCONST " . $data['plurar'] . ' = [';
            foreach ($data['items'] as $item) {
                $items[] = "\t\tself::" . $name . '_' . strtoupper($item) . ' => \'' . $item . '\',';
            }
            $items[] = "\t];";
            $items[] = '';
        }
        
        return implode("\n", $items);
    }
    
    /*
     * @param array $data
     * @return string
     */
    public function formatArray(array $data): string
    {
        $content = var_export($data, true);
        $content = str_replace(['array (', ')', '  '], ['[', ']', "\t"], $content);
        $content = str_replace([" => \n\t["], [" => ["], $content);
        $content = str_replace([" => \n\t\t["], [" => ["], $content);
        $content = str_replace([" => \n\t\t\t["], [" => ["], $content);
        $content = str_replace([" => \n\t\t\t\t["], [" => ["], $content);
        
        for ($i=20; $i>= 0; $i--) {
            $content = str_replace([$i. ' =>'], '', $content);            
        }
        
        //dd(explode("\n", $content));
        
        $content = array_filter(explode("\n", $content), function($value){
            return trim(str_replace(["\t", "\n", "\r"], "", $value)) !== '';
        });
        
        $content = implode("\n", $content);
        
        return $content;
    }
    
}
