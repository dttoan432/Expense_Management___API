<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
            'name'          => ['required','max:50',Rule::unique('roles')->ignore($this->id, '_id')],
            'description'   => 'max:255'
        ];
    }

    public function messages()
    {
        return [
            'required'  => ':attribute không được để trống.',
            'max'       => ':attribute tối đa :max ký tự.',
            'unique'    => ':attribute đã tồn tại.',
        ];
    }

    public function attributes()
    {
        return [
            'name'          => 'Tên vai trò',
            'description'   => 'Mô tả',
        ];
    }
}
