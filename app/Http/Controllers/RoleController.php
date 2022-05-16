<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    use ResponseTrait;

    /**
     * Lấy danh sách vai trò.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = Role::query();

            if ($request->has('qr')) {
                $query->where('name', 'like', '%' . $request->input('qr') . '%');
            }

            $roles = $query->orderBy('created_at', 'asc')
                ->paginate(config('constants.per_page'));

            return $this->responseSuccess($roles);
        } catch (\Exception $e) {
            Log::error('ERROR - Lấy danh sách vai trò thất bại.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }

    /**
     * Tạo mới vai trò.
     *
     * @param StoreRoleRequest $request
     * @return JsonResponse
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            $role = new Role();
            $role->name = $request->input('name');
            $role->description = $request->input('description');
            $role->is_protected = false;
            $role->save();

            return $this->responseSuccess();
        } catch (\Exception $e) {
            Log::error('ERROR - Tạo mới vai trò thất bại', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }

    /**
     * Cập nhật thông tin vai trò.
     *
     * @param UpdateRoleRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->name = $request->input('name');
            $role->description = $request->input('description');
            $role->save();

            return $this->responseSuccess();
        } catch (Exception $e) {
            Log::error('ERROR - Cập nhật thông tin vai trò thất bại.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }

    /**
     * Xóa vai trò.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            Role::findOrFail($id)->delete();

            return $this->responseSuccess();
        } catch (Exception $e) {
            Log::error('ERROR - Xóa vai trò thất bại.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }

    /**
     * Cập nhật quyền hạn cho vai trò.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updatePermissionForRoles(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $permissionIds = $request->input('permissionIds');

            if (sizeof($permissionIds) > 0) {
                $isExists = $this->isExistsPermission($request->input('permissionIds'));
                if (!$isExists) return $this->responseError('Quyền hạn không tồn tại');
            }
            $role->permissions()->sync($request->input('permissionIds'));

            return $this->responseSuccess();
        } catch (Exception $e) {
            Log::error('ERROR - Cập nhật quyền hạn cho vai trò thất bại.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }

    /**
     * Kiểm tra quyền hạn có tồn tại hay không.
     *
     * @param $data
     * @return bool
     */
    public function isExistsPermission($permissions) {
        try {
            $isExsts = false;
            foreach ($permissions as $permission) {
                $isExsts = Permission::where('_id', $permission)->exists();
            }

            return $isExsts;
        } catch (\Exception $e) {
            Log::error('Kiểm tra sự tồn tại của quyền hạn thất bại.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return false;
        }
    }
}
