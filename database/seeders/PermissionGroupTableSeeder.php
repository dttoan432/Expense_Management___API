<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;

class PermissionGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::checkBeforeCreate([
            'name'          => 'Quản lý người dùng',
            'code'          => 'user-management',
            'description'   => 'Quản lý toàn bộ chức năng liên quan đến người dùng'
        ]);

        self::checkBeforeCreate([
            'name'          => 'Quản lý vai trò',
            'code'          => 'role-management',
            'description'   => 'Quản lý toàn bộ chức năng liên quan đến vai trò'
        ]);
    }

    public function checkBeforeCreate($data) {
        PermissionGroup::updateOrCreate(
            [
                'code' => $data['code']
            ],
            [
                'name'          => $data['name'],
                'description'   => $data['description']
            ]
        );
    }
}
