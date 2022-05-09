<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleSuperAdmin = Role::where('name', 'Super Admin')->first()->_id;

        User::updateOrCreate(
            [
                'email' => 'admin@gmail.com'
            ],
            [
                'name'      => 'Admin',
                'password'  => Hash::make('admin432000'),
                'phone'     => '0383584504',
                'avatar'    => null,
                'is_active' => true,
                'role_id'   => $roleSuperAdmin
            ]
        );

        for ($i = 1; $i <= 500; $i++) {
            User::updateOrCreate(
                [
                    'email' => 'user' . $i . '@gmail.com'
                ],
                [
                    'name'      => 'User' . $i,
                    'password'  => Hash::make('admin432000'),
                    'phone'     => '03' . random_int(11111111, 99999999),
                    'avatar'    => null,
                    'is_active' => true
                ]
            );
        }
    }
}
