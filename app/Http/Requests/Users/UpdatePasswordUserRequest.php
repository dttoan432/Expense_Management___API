<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordUserRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password'              => 'required|max:32|min:8',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'required'         => ':attribute không được để trống.',
            'max'              => ':attribute tối đa :max ký tự.',
            'min'              => ':attribute tối thiểu :min ký tự.',
            'same'             => ':attribute không khớp.',
        ];
    }

    public function attributes()
    {
        return [
            'password'              => 'Mật khẩu',
            'password_confirmation' => 'Mật khẩu xác nhận',
        ];
    }
}
