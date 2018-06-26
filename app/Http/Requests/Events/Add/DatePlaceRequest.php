<?php

namespace App\Http\Requests\Events\Add;

use App\Http\Requests\Request;

class DatePlaceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required|date_format:"d.m.Y"',
            'time' => 'required|date_format:"H:i"',
            'place' => 'nullable|string|min:2',
            'place_friendly' => 'required|string|min:10',
        ];
    }
}
