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
            'code'                  => 'super-admin',
            'name'                  => 'Toàn bộ quyền',
            'description'           => 'Có toàn quyền sử dụng hệ thống',
            'permission_group_code' => null,
        ]);

        // Quản lý người dùng
        self::checkBeforeCreate([
            'code'                  => 'get-users',
            'name'                  => 'Xem danh sách người dùng',
            'description'           => 'Xem danh sách người dùng',
            'permission_group_code' => 'user-management',
        ]);

        self::checkBeforeCreate([
            'code'                  => 'create-user',
            'name'                  => 'Thêm mới người dùng',
            'description'           => 'Thêm mới người dùng',
            'permission_group_code' => 'user-management',
        ]);

        self::checkBeforeCreate([
            'code'                  => 'update-user',
            'name'                  => 'Chỉnh sửa người dùng',
            'description'           => 'Chỉnh sửa người dùng',
            'permission_group_code' => 'user-management',
        ]);

        self::checkBeforeCreate([
            'code'                  => 'delete-user',
            'name'                  => 'Xóa người dùng',
            'description'           => 'Xóa người dùng',
            'permission_group_code' => 'user-management',
        ]);

        self::checkBeforeCreate([
            'code'                  => 'update-user-password',
            'name'                  => 'Thay đổi mật khẩu người dùng',
            'description'           => 'Thay đổi mật khẩu người dùng',
            'permission_group_code' => 'user-management',
        ]);

        self::checkBeforeCreate([
            'code'                  => 'update-user-status',
            'name'                  => 'Thay đổi trạng thái người dùng',
            'description'           => 'Thay đổi trạng thái người dùng',
            'permission_group_code' => 'user-management',
        ]);

        // Quản lý vai trò
        self::checkBeforeCreate([
            'code'                  => 'get-roles',
            'name'                  => 'Xem danh sách vai trò',
            'description'           => 'Xem danh sách vai trò',
            'permission_group_code' => 'role-management',
        ]);

        self::checkBeforeCreate([
            'code'                  => 'create-role',
            'name'                  => 'Thêm mới vai trò',
            'description'           => 'Thêm mới vai trò',
            'permission_group_code' => 'role-management',
        ]);

        self::checkBeforeCreate([
            'code'                  => 'update-role',
            'name'                  => 'Chỉnh sửa vai trò',
            'description'           => 'Chỉnh sửa vai trò',
            'permission_group_code' => 'role-management',
        ]);

        self::checkBeforeCreate([
            'code'                  => 'delete-role',
            'name'                  => 'Xóa vai trò',
            'description'           => 'Xóa vai trò',
            'permission_group_code' => 'role-management',
        ]);

        self::checkBeforeCreate([
            'code'                  => 'update-permissions-for-role',
            'name'                  => 'Cập nhật quyền cho vai trò',
            'description'           => 'Cập nhật quyền cho vai trò',
            'permission_group_code' => 'role-management',
        ]);

        self::checkBeforeCreate([
            'code'                  => 'get-permissions',
            'name'                  => 'Xem danh sách quyền',
            'description'           => 'Xem danh sách quyền',
            'permission_group_code' => 'role-management',
        ]);
    }

    public function checkBeforeCreate($data)
    {
        Permission::updateOrCreate(
            [
                'code' => $data['code']
            ],
            [
                'name'                  => $data['name'],
                'permission_group_code' => $data['permission_group_code'],
                'description'           => $data['description']
            ]
        );
    }
}
