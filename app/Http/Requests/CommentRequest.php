<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'content'=>'required',
            'name'=>'required',
            'email' => 'required |email'
        ];
    }

    public function messages(): array {
        return [
            'content.required' => 'Vui lòng nhập nội dung bình luận',
            'name.required' => 'Vui lòng nhập họ va tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Vui lòng nhập đúng định dang email',
        ];
    }
}
