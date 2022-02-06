<?php

namespace Database\Seeders;

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
        $user = User::updateOrCreate(
            [
                'email' => 'admin@gmail.com'
            ],
            [
                'name'      => 'Admin',
                'password'  => Hash::make('admin'),
                'phone'     => '0383584504',
                'avatar'    => null,
                'is_active' => true
            ]
        );
    }
}
