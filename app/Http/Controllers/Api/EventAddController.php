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
    
    /**
     * Event category validation
     * @param CategoryRequest $request
     * @return string
     */
    public function category(Requests\Events\Add\CategoryRequest $request)
    {
        return response()->json(['success' => true]);
    }
    
    /**
     * Event date and place validation
     * @param DatePlaceRequest $request
     * @return string
     */
    public function datePlace(Requests\Events\Add\DatePlaceRequest $request)
    {
        return response()->json(['success' => true]);
    }
    
    /**
     * Event tickets validation
     * @param TicketsRequest $request
     * @return string
     */
    public function tickets(Requests\Events\Add\TicketsRequest $request)
    {
        return response()->json(['success' => true]);
    }
}
