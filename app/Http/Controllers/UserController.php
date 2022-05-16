<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdatePasswordUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Traits\HelperTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ResponseTrait;
    use HelperTrait;

    /**
     * Lấy danh sách người dùng.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = User::query()->with(['role']);

            if ($request->has('qr')) {
                $query->where('name', 'like', '%' . $request->input('qr') . '%')
                    ->orWhere('email', 'like', '%' . $request->input('qr') . '%')
                    ->orWhere('phone', 'like', '%' . $request->input('qr') . '%');
            }

            $users = $query->orderBy('created_at', 'desc')
                ->paginate(config('constants.per_page'));

            foreach ($users as $user) {
                if (!empty($user->avatar)) $user->avatar = $this->getUrlFileFormStorage($user->avatar);
            }
            return $this->responseSuccess($users);
        } catch (Exception $e) {
            Log::error('ERROR - Lấy danh sách người dùng thất bại.', [
                'method'    => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }

    /**
     * Lấy danh sách tất cả vai trò.
     *
     * @return JsonResponse
     */
    public function getAllRoles()
    {
        try {
            $roles = Role::where('name', '<>', 'Super Admin')->get();

            return $this->responseSuccess($roles);
        } catch (\Exception $e) {
            Log::error('ERROR - Lấy danh sách tất cả vai trò thất bại.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }

    /**
     * Tạo mới người dùng.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = new User();
            $user->name         = $request->input('name');
            $user->email        = $request->input('email');
            $user->phone        = $request->input('phone');
            $user->is_active    = $request->input('is_active');
            $user->role_id      = $request->input('role_id');
            $user->password     = Hash::make($request->input('password'));
            if ($request->hasFile('avatar')) {
                $path = Storage::disk('public')->putFile('/avatar', $request->file('avatar'));
                $user->avatar = $path;
            }
            $user->save();

            return $this->responseSuccess();
        } catch (Exception $e) {
            Log::error('ERROR - Tạo mới người dùng thất bại.', [
                'method'    => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }

    /**
     * Cập nhật thông tin người dùng.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->name         = $request->input('name');
            $user->email        = $request->input('email');
            $user->phone        = $request->input('phone');
            $user->is_active    = $request->input('is_active');
            $user->role_id      = $request->input('role_id');
            if ($request->hasFile('avatar')) {
                $path = Storage::disk('public')->putFile('/avatar', $request->file('avatar'));
                $user->avatar = $path;
            }
            $user->save();

            return $this->responseSuccess();
        } catch (Exception $e) {
            Log::error('ERROR - Cập nhật thông tin người dùng thất bại.', [
                'method'    => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }

    /**
     * Xóa người dùng.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return $this->responseSuccess();
        } catch (Exception $e) {
            Log::error('ERROR - Xóa người dùng thất bại.', [
                'method'    => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }

    /**
     * Cập nhật trạng thái người dùng.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateStatusActive(Request $request, $id)
    {
        try {
            User::findOrFail($id)->update([
                'is_active' => $request->input('is_active')
            ]);

            return $this->responseSuccess();
        } catch (Exception $e) {
            Log::error('ERROR - Cập nhật trạng thái người dùng thất bại.', [
                'method'    => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }

    /**
     * Thay đổi mật khẩu người dùng
     *
     * @param UpdatePasswordUserRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function updatePassword(UpdatePasswordUserRequest $request, $id)
    {
        try {
            User::findOrFail($id)->update([
                'password' => Hash::make($request->input('password'))
            ]);

            return $this->responseSuccess();
        } catch (Exception $e) {
            Log::error('ERROR - Thay đổi mật khẩu người dùng thất bại.', [
                'method'    => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }
}
