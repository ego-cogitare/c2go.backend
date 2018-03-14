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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'podcast_id' => 'nullable|exists:podcasts,id',
            'password_hint' => 'nullable',
            /*
            'city' => 'nullable|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'company_name' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'zip' => 'nullable|string',
            'state_id' => 'nullable|exists:states,id',
            */
        ];
    }
}
