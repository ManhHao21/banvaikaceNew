<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required| min:6',
            're_password' => 'required|min:6|same:password',
            'phone' => 'required|min:10|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Họ và tên không được bỏ trống",
            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Không đúng định dạng email, vui lòng nhập đúng admin@gmail.com!',
            'email.unique' => "email đã tồn tại, vui lòng nhập lại",
            "password.required" => "Mật khẩu không được bỏ trống",
            "password.min" => "Mật khẩu phải lớn hơn :min kí tự",
            "re_password.required" => "Mật khẩu nhập lại không được bỏ trống",
            "re_password.min" => "Mật khẩu phải lớn hơn :min kí tự",
            "re_password.same" => "Vui lòng nhập trùng với mật khẩu!!!",
            'phone.required' => "Số điện thoại không được bỏ trống",
            'phone.min' => "Số điện thoại phải 10 kí tự, vui lòng nhập lại!!"
        ];

    }
}
