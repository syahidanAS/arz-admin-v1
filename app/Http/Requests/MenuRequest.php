<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'name' => 'required|unique:menus,name|max:50',
            'url' => 'required|max:50',
            'icon' => 'required|max:2000',
            'type' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'     =>  'Nama menu harus diisi!',
            'name.unique'     =>  'Nama menu sudah digunakan!',
            'name.max'     =>  'Nama menu terlalu panjang!',
            'url.required'     =>  'URL harus diisi!',
            'url.max'     =>  'URL terlalu panjang!',
            'icon.required'     =>  'Icon harus diisi!',
            'icon.max'     =>  'Icon terlalu panjang!',
            'type.required' => 'Tipe menu harus diisi!'
        ];
    }
}
