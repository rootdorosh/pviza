<?php

namespace App\Modules\User\Database\Seeds;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = config('roles.models.role')::where('name', '=', 'Admin')->first();
        $permissions = config('roles.models.permission')::all();
        
        $items = [
            [
                'email' => 'ls@sunbee.studio',
                'password' => 'liko101010',
                'name' => 'LS',
                'position' => 'Designer',
            ],
            [
                'email' => 'vasyldorosh@gmail.com',
                'password' => 'dorosh123',
                'name' => 'VD',
                'position' => 'Backend developer',
            ],
            [
                'email' => 'mr.ap2089@gmail.com',
                'password' => 'ap1021d',
                'name' => 'AP',
                'position' => 'Frontend developer',
            ],
        ];
        
        foreach ($items as $item) {
            if (config('roles.models.defaultUser')::where('email', '=', $item['email'])->first() === null) {
                $item['is_active'] = 1;
                $user = config('roles.models.defaultUser')::create($item);
                $user->roles()->sync([$adminRole->id]);
            }
        }        

    }
}
