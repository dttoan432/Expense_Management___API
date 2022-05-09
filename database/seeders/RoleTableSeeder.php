<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::where('name', 'super-admin')->first();

        $roleAdmin = Role::updateOrCreate(
            [
                'name' => 'Super Admin'
            ],
            [
                'name' => 'Super Admin',
                'description' => 'Quản trị hệ thống',
                'is_protected' => true,
            ]
        );
        $roleAdmin->permissions()->attach($permission->_id);
    }
}
