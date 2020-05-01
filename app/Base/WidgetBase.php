<?php

namespace App\Base;

//use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use App\Modules\Structure\Http\Requests\Block\InsertRequest;
use App\Modules\Structure\Services\StructureService;
use FrontPage;

//abstract class WidgetBase extends AbstractWidget
abstract class WidgetBase
{
    /*
     * @var string
     */
    public $widget_id;

    /*
     * @var string
     */
    public $alias;

    /*
     * @var string
     */
    public $action = 'index';
        
    /*
     * @return array
     */
    abstract public function getActions(): array;

    /*
     * @return string
     */
    abstract public function getName(): string;
    
    /*
     * @return string
     */
    public function getModule(): string
    {
        $parts = explode('\\', static::class);
        return $parts[2];
    }
    
    /*
     * @return bool
     */
    public function getIsAllowAjax(): bool
    {
        $widgetID = request()->header('WIDGET-ID');
        $actionID = request()->header('ACTION-ID');
        
        if (!$widgetID && isset($_GET['WIDGET-ID'])) {
            $widgetID = $_GET['WIDGET-ID'];
        }
        if (!$actionID && isset($_GET['ACTION-ID'])) {
            $actionID = $_GET['ACTION-ID'];
        }
        
        return strtolower($widgetID) === strtolower($this->getModule()) &&
               strtolower($actionID) === strtolower($this->action);
    }
    
    
    /*
     * @var array
     */
    protected static $dependencies = [];


    /*
     * constructor
     * 
     * @param array $attributes
     * @param string $action
     */
    public function __construct(string $action = null, array $attributes = [])
    {
        //$this->addConfigDefaults(static::getAttributes());
        
        foreach ($attributes as $key => $val) {
            $this->$key = $val;
        }
        
        if ($action !== null) {
            $this->action = $action;
        }
        
        foreach (static::$dependencies as $property => $namespace) {
            $this->$property = resolve($namespace);
        }

        //parent::__construct();
    }
    
    /*
     * @return array
     */
    public function getConfig(): array
    {
        return [
            [
                'name' => 'action',
                'label' => __('main.widget_action'),
                'type' => 'select',
                'options' => $this->getActions(),
            ]
        ];
    }

    /**
     * @param string $action
     * @return string|null
     */
    public function getActionTitle(string $action):? string
    {
        $list = $this->getActions();
        return isset($list[$action]) ? $list[$action] : null;
    }
    
    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'action' => __('widget_action'),
        ];
    }
    
    /**
     * @param InsertRequest $request
     * @return array
     */
    public function rules(InsertRequest $request): array
    {
        return [
            'action' => [
                'required',
                'string',
                'in:' . implode(',', array_keys($this->getActions())),
            ],
        ];
    }
    
    /*
     * @param string $action
     * @return bool
     */
    protected function hasAction(string $action): bool
    {
        return array_key_exists($action, $this->getActions());
    }

    /**
     */
    public function run()
    {      
        foreach (static::$dependencies as $property => $namespace) {
            $this->$property = resolve($namespace);
        }
        
        if ($this->hasAction($this->action)) {
            if (!FrontPage::hasPage()) {
                return static::getName() . '. ' . $this->getActionTitle($this->action);
            
            // call widget from front    
            } else {
                
                if (request()->ajax()) {
                    if ($this->getIsAllowAjax()) {
                        $funcName = "action" . ucfirst($this->action);
                        $response = $this->{$funcName}();
                        echo is_array($response) ? json_encode($response) : $response;  
                        die();
                    }
                    
                } else {
                    $funcName = "action" . ucfirst($this->action);
                    return $this->{$funcName}();
                }
            } 
        }
    }    
    
    /*
     * @return string
     */
    protected function getViewPath(): string
    {
        $parts = explode('\\', static::class);
        unset($parts[0], $parts[count($parts)]);
        
        return app_path() . '/' . implode('/', $parts) . '/views/';
    }
    
    /*
     * render view
     * 
     * @param string $view
     * @param array $data
     * @return string
     */
    public function view(string $view, array $data = []): string
    {
        $view = str_replace('.', '/', $view);
        $file = $this->getViewPath() . $view . '.blade.php';
        if (!is_file($file)) {
            $file = $this->getViewPath() . $view . '.php';
        }
        
        $data['widget'] = new static;
        
        return view()->file($file, $data)->render();
    }
   
    public function render404()
    {
        echo (new StructureService)->renderPage('404');
        die();
    }
}