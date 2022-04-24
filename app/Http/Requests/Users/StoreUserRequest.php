<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $isActive = $this->is_active === "true";

        $this->merge([
            'is_active' => $isActive,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'avatar'                => 'nullable|image',
            'name'                  => 'required|max:50',
            'email'                 => 'required|max:64|email|unique:users,email',
            'phone'                 => ['nullable','digits:10','unique:users,phone','regex:/(84|0[3|5|7|8|9])+([0-9]{8})\b/'],
            'password'              => 'required|max:32|min:8',
            'password_confirmation' => 'required|same:password',
            'role_id'               => 'nullable|exists:users,_id',
            'is_active'             => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'image'            => ':attribute sai định dạng.',
            'required'         => ':attribute không được để trống.',
            'max'              => ':attribute tối đa :max ký tự.',
            'min'              => ':attribute tối thiểu :min ký tự.',
            'email'            => ':attribute sai định dạng.',
            'unique'           => ':attribute đã tồn tại.',
            'digits'           => ':attribute sai định dạng.',
            'regex'            => ':attribute sai định dạng.',
            'same'             => ':attribute không khớp.',
            'exists'           => ':attribute không hợp lệ.',
            'boolean'          => ':attribute không hợp lệ.',
        ];
    }

    public function attributes()
    {
        return [
            'avatar'                => 'Ảnh đại diện',
            'name'                  => 'Họ tên',
            'email'                 => 'Email',
            'phone'                 => 'Số điện thoại',
            'password'              => 'Mật khẩu',
            'password_confirmation' => 'Mật khẩu xác nhận',
            'role_id'               => 'Vai trò',
            'is_active'             => 'Trạng thái',
        ];
    }
}
