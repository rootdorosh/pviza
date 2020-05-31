<?php

namespace App\Base;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FrontController extends Controller
{
    /*
     * render view
     * 
     * @param string $view
     * @param array $data
     * @return View
     */
    public function view(string $view, array $data = []): View
    {
        $view = str_replace('.', '/', $view);
        $file = $this->getViewPath() . $view . '.blade.php';
        if (!is_file($file)) {
            $file = $this->getViewPath() . $view . '.php';
        }
        
        return view()->file($file, $data);
    }   
    
    /*
     * @return string
     */
    protected function getViewPath(): string
    {
        return base_path() . '/' . str_replace('\\', '/', Str::before(static::class, '\\Http')) . '/views/';
    }
    
}
