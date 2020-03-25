<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ModuleSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:seed {name}';

    /**
     * The console command description.
     * https://op.mos.ru/EHDWSREST/catalog/export/get?id=484577
     *
     * @var string
     */
    protected $description = 'Run module seeder';

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
        $name = Str::studly($this->argument('name'));
        
        $seeder = resolve("\App\Modules\\$name\Database\Seeds\MainSeeder");
        $seeder->run();
        
        $this->output->writeln("<info>Module {$name} seeded</info>");
    }
}
