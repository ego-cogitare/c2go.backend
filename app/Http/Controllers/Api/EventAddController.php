<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\EventProposal;
use Carbon\Carbon;

class EventAddController extends Controller
{
    /**
     * Event general info (title|description|url) validation
     * @param GeneralInfoRequest $request
     * @return string
     */
    public function general(Requests\Events\Add\GeneralInfoRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->only([
                'title',
                'description',
                'url',
                'event_id'
            ])
        ]);
    }
    
    /**
     * Event category validation
     * @param CategoryRequest $request
     * @return string
     */
    public function category(Requests\Events\Add\CategoryRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->only([
                'category'
            ])
        ]);
    }
    
    /**
     * Event date and place validation
     * @param DatePlaceRequest $request
     * @return string
     */
    public function datePlace(Requests\Events\Add\DatePlaceRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->only([
                'timestamp',
                'event_dispatch',
                'event_dispatch_latlng',
                'event_destination',
                'event_destination_latlng',
                'event_meet_place',
                'event_meet_place_latlng',
                'changes',
                'category_id',
            ])
        ]);
    }
    
    /**
     * Event tickets validation
     * @param TicketsRequest $request
     * @return string
     */
    public function tickets(Requests\Events\Add\TicketsRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->only([
                'bought',
                'price'
            ])
        ]);
    }
    
    /**
     * Event meet place validation
     * @param MeetPlaceRequest $request
     * @return string
     */
    public function add(Requests\Events\Add\AddRequest $request)
    {
        /** @var array $data */
        $data = $this->all();
        
        /** Creating new event scenario */
        if (empty($data['event_id'])) {
            $event = Event::create([
                'category_id'        => $data['category_id'],
                'user_id'            => Auth::user()->id,
                'name'               => $data['title'],
                'description'        => $data['description'],
                'url'                => $data['url'],
                'date'               => Carbon::createFromTimestamp($data['timestamp'])->toDateTimeString(),
                'destination'        => $data['event_destination'],
                'destination_latlng' => json_encode($data['event_destination_latlng']),
                'dispatch'           => $data['event_destination'],
                'dispatch_latlng'    => json_encode($data['event_dispatch_latlng']),
                
            ]);
            
            EventProposal::create([
                'event_id' => $event->id,
                'user_id'  => $event->user_id,
                'price'    => $data['price'],
                'message'  => $data['meet_place'],
            ]);
            
            /** If phone number provided and it is not in the user's phones list */
//            if ($data['telephone'] && !Auth::user()->hasPhone($data['telephone'])) {
//                Auth::user()->addPhone($data['telephone']);
//            }
        /** Add event proposal for already existing event */
        } else {
            
        }
        
        return response()->json([
            'success' => true,
            'data' => $request->all()
        ]);
    }
}
