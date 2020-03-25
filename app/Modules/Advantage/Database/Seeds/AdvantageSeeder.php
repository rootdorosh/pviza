<?php 

namespace App\Modules\Advantage\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Advantage\Models\Advantage;


class AdvantageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        factory(Advantage::class, 100)->create();
    }
}
