<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TestimonialCreateRequest extends Request
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
            'rate'=>'required|int|min:1|max:5',
            'message'=>'required|string|min:10|max:255',
            'user_agreement'=>'nullable|int',
        ];
    }
}
