<?php

use Illuminate\Database\Seeder;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(App\Modules\Structure\Database\Seeds\StructureSeeder::class);        
    }
}
