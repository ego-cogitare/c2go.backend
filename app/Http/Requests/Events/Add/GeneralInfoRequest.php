<?php

namespace App\Http\Requests\Events\Add;

use App\Http\Requests\Request;

class GeneralInfoRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    public function messages()
    {
        return [
//            'title.required' => 'A title is required',
//            'body.required'  => 'A message is required',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public static function rules()
    {
        return [
            'title' => 'required|string|min:3|max:120',
            'event_id' => 'nullable|int|exists:events,id',
            'description' => 'required|string|min:10|max:120',
            'url' => 'nullable|url',
        ];
    }
}
