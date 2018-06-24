<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventAddController extends Controller
{
    /**
     * Event general info (title|description|url) validation
     * @param GeneralInfoRequest $request
     * @return string
     */
    public function general(Requests\Events\Add\GeneralInfoRequest $request)
    {
        return response()->json(['success' => true]);
    }
}
