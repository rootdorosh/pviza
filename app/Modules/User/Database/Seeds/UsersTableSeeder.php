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
                'email' => 'vasyldorosh@gmail.com',
                'password' => 'dorosh123',
                'name' => 'VD',
                'position' => 'Backend developer',
            ],
        ];

        foreach ($items as $item) {
            $user = config('roles.models.defaultUser')::where('email', '=', $item['email'])->first();

            if ($user) {
                $user->is_active = 1;
                $user->password = $item['password'];
                $user->save();
            }
        }

    }
}
