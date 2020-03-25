namespace App\Modules\<?= $moduleName?>\Database\Seeds;

use Illuminate\Database\Seeder;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {@foreach ($models as $model)  
       $this->call({{ $model }}Seeder::class);@endforeach
       
    }
}
