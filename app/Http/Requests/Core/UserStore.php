<?php

namespace App\Http\Requests\Core;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserStore extends FormRequest
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
            'name' => 'required',
            'email' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'password.required' => 'Favor ingrese contraseña',
            'password.min' => 'Debe ingresar al menos 3 caracteres',
            'email.required' => 'El email es obligatorio',
        ];
    }
}
