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
     * @param $permission
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        try {
            if (!empty(auth()->user()->role_id)) {
                $role = Role::findOrFail(auth()->user()->role_id);

                $isSuperAdmin = $this->hasPermission($role->permission_ids, 'super-admin');
                if ($isSuperAdmin) return $next($request);

                $hasPermission = $this->hasPermission($role->permission_ids, $permission);
                if ($hasPermission) return $next($request);
            }

            return $this->responseError('Bạn không có quyền truy cập tính năng này.', [],
                Response::HTTP_FORBIDDEN,
                403
            );
        } catch (Exception $e) {
            Log::error('ERROR - Đã xảy ra lỗi khi xác thực quyền của người dùng.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            $this->responseError();
        }
    }

    /**
     * @param $permissions
     * @param $permission
     * @return bool
     */
    public function hasPermission($permissions, $permission)
    {
        try {
            $permission = Permission::where('name', $permission)->firstOrFail();

            return in_array($permission->_id, $permissions);
        } catch (\Exception $e) {
            Log::error('ERROR - Đã xảy ra lỗi khi xác thực quyền của người dùng.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return false;
        }
    }
}
