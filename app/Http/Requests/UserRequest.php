<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|max:50',
            'email' => 'required|unique:users,email|max:50',
            'nik' => 'required|unique:users,nik|max:50',
            'password' => 'required|max:3000',
            'role' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     =>  'Nama pengguna harus diisi!',
            'name.max'     =>  'Nama pengguna terlalu panjang!',
            'email.required'     =>  'Alamat email harus diisi!',
            'email.unique'     =>  'Alamat email sudah digunakan!',
            'email.max'     =>  'Alamat email terlalu panjang!',
            'password.required'     =>  'Password harus diisi!',
            'email.max'     =>  'Password terlalu panjang!',
            'role.required' => 'Role harus dipilih!',
            'nik.required'     =>  'NIK harus diisi!',
            'nik.unique'     =>  'NIK sudah digunakan!',
            'nik.max'     =>  'NIK terlalu panjang!',
        ];
    }
}
