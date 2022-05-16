<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $permission = Permission::where('code', 'super-admin')->first();

        $roleAdmin = Role::updateOrCreate(
            [
                'name' => 'Super Admin'
            ],
            [
                'description'   => 'Quản trị hệ thống',
                'is_protected'  => true,
            ]
        );
        $roleAdmin->permissions()->attach($permission->_id);
    }
}
