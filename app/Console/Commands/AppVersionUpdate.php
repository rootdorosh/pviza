<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ModuleGenerator\ModuleGeneratorService;
use Cache;
use App\Base\ScmsHelper;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Artisan;

class AppVersionUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app_version:update';

    /**
     * The console command description.
     * https://op.mos.ru/EHDWSREST/catalog/export/get?id=484577
     *
     * @var string
     */
    protected $description = 'update app version';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('config:clear');
        $this->setEnvironmentValue('APP_VERSION', (int) config('app.version') + 1);
    }
 
    public function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $oldValue = strtok($str, "{$envKey}=");

        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }    
}
