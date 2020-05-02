<?php

use Illuminate\Database\Seeder;
use App\Modules\Event\Database\Seeds\EventsTableSeeder;
use App\Modules\User\Database\Seeds\PermissionsTableSeeder;
use App\Modules\User\Database\Seeds\ConnectRelationshipsSeeder;
use App\Modules\Structure\Database\Seeds\StructureSeeder;
use App\Modules\Translation\Database\Seeds\TranslationSeeder;
use App\Modules\Icon\Jobs\SpriteJob;

class SyncSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $this->call(PermissionsTableSeeder::class);
       $this->call(ConnectRelationshipsSeeder::class);
       $this->call(EventsTableSeeder::class);
       $this->call(StructureSeeder::class);
       $this->call(TranslationSeeder::class);
    }
}
