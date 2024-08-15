<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'email' => 'required|max:50',
            'password' => 'max:3000',
            'role' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     =>  'Nama pengguna harus diisi!',
            'name.max'     =>  'Nama pengguna terlalu panjang!',
            'email.required'     =>  'Alamat email harus diisi!',
            'email.max'     =>  'Alamat email terlalu panjang!',
            'email.max'     =>  'Password terlalu panjang!',
            'role.required' => 'Role harus dipilih!'
        ];
    }
}
