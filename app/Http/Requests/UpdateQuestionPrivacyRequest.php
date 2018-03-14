<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class UpdateQuestionPrivacyRequest extends Request
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
//            'question_id' => 'required|numeric|exists:questions,id',
//            'user_id' => 'required|numeric|exists:users,id',
            'privacy_level' => 'required|numeric|min:1|max:3',
            'privacy_users' => 'nullable|array|exists:users,id'
        ];
    }
}
