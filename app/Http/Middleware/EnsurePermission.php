<?php

namespace App\Http\Middleware;

use App\Http\Traits\ResponseTrait;
use App\Models\Permission;
use App\Models\Role;
use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EnsurePermission
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $permissions
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next, ... $permissions)
    {
        try {
            if (!empty(auth()->user()->role_id)) {
                $role = Role::findOrFail(auth()->user()->role_id);

                $isSuperAdmin = $this->hasPermission($role->permission_ids, ['super-admin']);
                if ($isSuperAdmin) return $next($request);

                $hasPermission = $this->hasPermission($role->permission_ids, $permissions);
                if ($hasPermission) return $next($request);
            }

            return $this->responseError('Bạn không có quyền truy cập tính năng này.', [],
                Response::HTTP_FORBIDDEN,
                403
            );
        } catch (Exception $e) {
            Log::error('ERROR - Lỗi xử lý middleware xác thực quyền hạn người dùng.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            $this->responseError();
        }
    }

    /**
     * @param $permissions
     * @param $permissionCode
     * @return bool
     */
    public function hasPermission($permissions, $permissionCodes)
    {
        $hasPermission = false;
        try {
            foreach ($permissionCodes as $permissionCode) {
                $permission = Permission::where('code', $permissionCode)->first();
                if (in_array($permission->_id, $permissions)) $hasPermission = true;
            }

            return $hasPermission;
        } catch (\Exception $e) {
            Log::error('ERROR - Xác thực quyền hạn của người dùng thất bại.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return false;
        }
    }
}
