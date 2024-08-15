<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name|max:50',
            'desc' => 'max:3000',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     =>  'Nama role harus diisi!',
            'name.unique'     =>  'Nama role sudah digunakan!',
            'name.max'     =>  'Nama role terlalu panjang!',
            'desc.max'     =>  'Deskripsi terlalu panjang!',
        ];
    }
}
