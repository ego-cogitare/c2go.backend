<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventProposal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $data = $request->all();
        
        /** Creating new event scenario */
        if (empty($data['event_id'])) {
            
            /** @var Event $event */
            $event = Event::create([
                'category_id'        => $data['category_id'],
                'user_id'            => Auth::user()->id,
                'name'               => $data['title'],
                'date'               => Carbon::createFromTimestamp($data['timestamp'])->toDateTimeString(),
                'destination'        => $data['event_destination'],
                'destination_latlng' => json_encode($data['event_destination_latlng']),
                'dispatch'           => $data['event_destination'],
                'dispatch_latlng'    => json_encode($data['event_dispatch_latlng']),
            ]);
        } else {
            $event = Event::findOrFail($data['event_id']);
        }
        
        /** If phone number is provided and user have no phone yet */
        if ($data['telephone'] && Auth::user()->getPhone() === '') {
            Auth::user()->setPhone($data['telephone']);
        }
        
        /** @var EventProposal $eventProposal */
        $eventProposal = EventProposal::create([
            'event_id'       => $event->id,
            'user_id'        => Auth::user()->id,
            'tickets_bought' => $data['bought'],
            'price'          => $data['price'],
            'message'        => $data['meet_place'],
            'description'    => $data['description'],
            'url'            => $data['url'],
        ]);
        
        return response()->json([
            'success' => true,
            'data' => [
                'event' => $event,
                'proposal' => $eventProposal,
            ]
        ]);
    }
}
