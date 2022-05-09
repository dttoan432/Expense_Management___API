<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::checkBeforeCreate([
            'name'                  => 'super-admin',
            'display_name'          => 'Toàn bộ quyền',
            'description'           => 'Có toàn quyền sử dụng hệ thống',
            'permission_group_code' => null,
        ]);

        // Quản lý người dùng
        self::checkBeforeCreate([
            'name'                  => 'get-users',
            'display_name'          => 'Xem danh sách người dùng',
            'description'           => 'Xem danh sách người dùng',
            'permission_group_code' => 'user-management',
        ]);

        self::checkBeforeCreate([
            'name'                  => 'create-user',
            'display_name'          => 'Thêm mới người dùng',
            'description'           => 'Thêm mới người dùng',
            'permission_group_code' => 'user-management',
        ]);

        self::checkBeforeCreate([
            'name'                  => 'update-user',
            'display_name'          => 'Chỉnh sửa người dùng',
            'description'           => 'Chỉnh sửa người dùng',
            'permission_group_code' => 'user-management',
        ]);

        self::checkBeforeCreate([
            'name'                  => 'delete-user',
            'display_name'          => 'Xóa người dùng',
            'description'           => 'Xóa người dùng',
            'permission_group_code' => 'user-management',
        ]);

        self::checkBeforeCreate([
            'name'                  => 'update-user-password',
            'display_name'          => 'Thay đổi mật khẩu người dùng',
            'description'           => 'Thay đổi mật khẩu người dùng',
            'permission_group_code' => 'user-management',
        ]);

        self::checkBeforeCreate([
            'name'                  => 'update-user-status',
            'display_name'          => 'Thay đổi trạng thái người dùng',
            'description'           => 'Thay đổi trạng thái người dùng',
            'permission_group_code' => 'user-management',
        ]);
    }

    public function checkBeforeCreate($data)
    {
        Permission::updateOrCreate(
            [
                'name' => $data['name']
            ],
            [
                'name'                  => $data['name'],
                'display_name'          => $data['display_name'],
                'permission_group_code' => $data['permission_group_code'],
                'description'           => $data['description']
            ]
        );
    }
}
