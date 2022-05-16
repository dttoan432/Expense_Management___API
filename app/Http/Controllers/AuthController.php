<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use ResponseTrait;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->responseError(
                'Thông tin tài khoản không chính xác',
                ['account' => ['Thông tin tài khoản không chính xác']],
                400, 400
            );
        }

        if (!auth()->user()->is_active) {
            return $this->responseError(
                'Tài khoản đã bị khóa',
                ['account' => ['Tài khoản đã bị khóa']],
                403, 403
            );
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        $user = auth()->user();
        $user->access_token = $this->respondWithToken(auth()->refresh())->original['access_token'];

        if ($user && $user->role_id) {
            $permissionIds = Role::find($user->role_id)->permission_ids;
            if (!empty($permissionIds)) {
                $permissionCodes = Permission::whereIn('_id', $permissionIds)->get();
                $permissions = collect($permissionCodes)->map(function ($permission) {
                    return $permission->code;
                });

                $user->permissions = $permissions;
            }
        }

        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
