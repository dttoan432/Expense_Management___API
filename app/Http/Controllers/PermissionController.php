<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\PermissionGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    use ResponseTrait;

    /**
     * Lấy danh sách quyền và nhóm quyền.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $permissionGroup = PermissionGroup::with(['permissions'])->get();

            return $this->responseSuccess($permissionGroup);
        } catch (\Exception $e) {
            Log::error('ERROR - Lấy danh sách quyền và nhóm quyền thất bại.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }
}
