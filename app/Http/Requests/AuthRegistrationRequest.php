<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AuthRegistrationRequest extends Request
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'birth_date' => 'required|string',
            'home_address' => 'required|string',
            'is_subscribed' => 'nullable|bool',
            'location' => 'required|array',
        ];
    }
}
