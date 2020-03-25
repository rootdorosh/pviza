<?php

namespace App\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FetchService
 */
class FetchService
{
    const EXP_HOUR = 60*60;
    const EXP_DAY = 60*60*24;
    const EXP_MONTH = 60*60*24*30;
    const EXP_YEAR = 60*60*24*365;
    
    /*
     * @var string
     */
    protected $tag;

    /*
     * @var Model
     */
    protected $model;
    
    /*
     * construct
     */
    public function __construct()
    {
        $modelNamespace = str_replace(
            ['Services\Fetch', 'FetchService'],
            ['Models', ''],
            static::class
        );
        
        $this->model = new $modelNamespace;
        
        $this->tag = $this->model->getTag();
    }

}