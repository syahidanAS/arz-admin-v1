<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'menu_name' => 'required|max:50',
            'action_name' => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     =>  'Nama permission harus diisi!',
            'name.unique'     =>  'Nama permission sudah digunakan!',
            'name.max'     =>  'Nama permission terlalu panjang!',
            'menu_name.required'     =>  'Kategori menu harus diisi!',
            'menu_name.max'     =>  'Kategori menu terlalu panjang!',
            'action_name.required'     =>  'Tindakan harus diisi!',
            'action_name.max'     =>  'Tindakan terlalu panjang!',
        ];
    }
}
