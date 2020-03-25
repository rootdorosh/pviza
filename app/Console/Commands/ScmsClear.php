<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ModuleGenerator\ModuleGeneratorService;
use Cache;
use App\Base\ScmsHelper;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ScmsClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scms:clear';

    /**
     * The console command description.
     * https://op.mos.ru/EHDWSREST/catalog/export/get?id=484577
     *
     * @var string
     */
    protected $description = 'Scms clear cache';

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
        Cache::tags(ScmsHelper::TAG)->flush();
        $this->output->writeln('<info>scms cache cleared</info>');
    }
}
