<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\EventRequest;
use App\Models\EventProposal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AutocompleteRequest;
use App\Interfaces\IAccountType;
use App\Interfaces\IEventStates;
use DB;

class EventsController extends Controller
{
    const RIDE_CATEGORY_IDS = [4];
    const DEFAULT_CATEGORY_ITEMS_LIMIT = 10;
    const TOP_CATEGORY_ITEMS_LIMIT = 3;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $date        = $request->input('date');
        $category_id = $request->input('category');
        $location    = $request->input('location');
        $destination = $request->input('destination');
        
        $result = [];
        
        for ($i = 1; $i >= 0; $i--) 
        {
            $events = Event::with([
                    'category',
                    'bestProposal' => function($query) {
                        $query->with(['user'])->select(['id', 'price', 'event_id', 'user_id']);
                    },
                ])
                ->where('is_top', $i)
                ->where('is_active', 1)
                ->where('date', '>', date('Y-m-d H:i:s'));
                
            // Filter parameters (apply only for none top events)
            if ($i === 0) 
            {
                $categories = [];
                
                // Get all children categories for the category
                if (!empty($category_id)) {
                    $categories = Category::where([
                        'parent_id' => $category_id,
                        'is_active' => 1
                    ])
                    ->pluck('id')
                    ->toArray();
                    
                    $categories[] = (int)$category_id;
                }
                
                // Filtering by date
                !empty($date) && $events->where('date', 'LIKE', Carbon::createFromFormat('d.m.Y', $date)->format('Y-m-d') . '%');
                
                // Filter by category and all child categories
                !empty($category_id) && $events->whereIn('category_id', $categories);
                
                // Filter by event location
                !empty($location) && $events->where('event_location_human', 'LIKE', $location);
                
                // Filter by destination location only for "Reise" category
                !empty($destination) && in_array($category_id, self::RIDE_CATEGORY_IDS) && $events->where('event_destination_human', $destination);
            }
            
            $events = $events->orderBy('date', 'ASC')->get();
            
            foreach ($events as $event) {
                $parent_category = $event->category->parent 
                    ? $event->category->parent 
                    : $event->category;

                if (empty($result[$i][$parent_category->id])) {
                    $result[$i][$parent_category->id] = [
                        'category' => $parent_category,
                        'events' => []
                    ];
                }
                
                /** 
                 * Limit top categories by 1 entry 
                 * Limit default categories by 10 entries (if separate category browse - results not limited)
                 */
                if ($i === 0 && empty($category_id) && sizeof($result[$i][$parent_category->id]['events']) >= self::DEFAULT_CATEGORY_ITEMS_LIMIT || 
                    $i === 1 && sizeof($result[$i][$parent_category->id]['events']) >= self::TOP_CATEGORY_ITEMS_LIMIT
                ) {
                    continue;
                }
                
                $result[$i][$parent_category->id]['events'][] = $event;
            }
            
            if (isset($result[$i])) {
                $result[$i] = array_values($result[$i]);
            }
        }
        
        if (isset($result[0])) {
            usort($result[0], function($a, $b) {
                return $a['category']['order'] < $b['category']['order'] ? -1 : 1;
            });
        }
        
        return response()->json([
            'success' => true, 
            'data' => $result
        ]);
    }
    
    public function proposals($id) 
    {
        $event = Event::with([
            'proposals' => function($query) use($id) {
                $query->with(['user'])->orderBy('price', 'ASC');
            }, 
            'user',
            'category', 
        ])
        ->find($id);
        
        if (empty($event)) {
            return response()->json(['success' => false], 404);
        }
        
        return response()->json([
            'success' => true, 
            'data' => $event
        ]);
    }
    
    public function details(Request $request, $proposal)
    {
        $limit = $request->get('limit', 5);
        $offset = $request->get('offset', 0);
        
        $event = EventProposal::with([
            'event' => function($query) {
                $query->with([
                    'category' => function($query) {
                        $query->with(['parent']);
                    }
                ]);
            }, 
            'user' => function($query) use($limit, $offset) {
                $query->with([
                    'reviews' => function($query) use($limit, $offset) {
                        $query->with(['user'])->limit($limit)->offset($offset);
                    }
                ]);
            },
        ])
        ->where('id', $proposal)
        ->first();
        
        if (empty($event)) {
            return response()->json(['success' => false], 404);
        }
        
        return response()->json([
            'success' => true, 
            'data' => $event
        ]);
    }
    
    public function general($proposal)
    {
        $event = EventProposal::with([
            'event' => function($query) {
                $query->with([
                    'category' => function($query) {
                        $query->with(['parent']);
                    }
                ]);
            }, 
            'user',
        ])
        ->where('id', $proposal)
        ->first();
        
        if (empty($event)) {
            return response()->json(['success' => false], 404);
        }
        
        return response()->json([
            'success' => true, 
            'data' => $event
        ]);
    }
    
    /**
     * Send event request to disabled user
     * @param Request $request
     * @param int $proposal
     * @return string
     */
    public function storeRequest(Request $request, $proposal)
    {
        $request->request->add([
            'event_proposals_id' => $proposal,
            'user_id' => Auth::user()->id,
        ]);
        
        $data = $request->only([
            'event_proposals_id',
            'user_id',
            'message',
        ]);
        
        $request->validate([
            'event_proposals_id' => 'required|integer|exists:event_proposals,id|unique:event_requests,event_proposals_id,NULL,id,user_id,' . Auth::user()->id,
            'user_id' => 'required|integer|exists:users,id',
            'message' => 'required|string|min:10|max:120',
        ], [
            'event_proposals_id.unique' => 'You already send request for this user and event.'
        ]);
        
        $event_request = EventRequest::create($data);
        
        return response()->json([
            'success' => true, 
            'data' => $event_request
        ]);
    }
    
    /**
     * Get current logged in user events requests
     */
    public function showUserRequests() 
    {
        $events = EventRequest::with(['requestor', 'proposal' => function($query) {
            $query->with(['user']);
        }])
        ->select(
            '*',
            'event_requests.id AS request_id',
            'event_requests.message AS request_message',
            'event_requests.user_id AS requestor_user_id',
            \DB::raw('DATE_FORMAT(events.date, \'%d.%m.%Y\') AS date')
        )
        ->leftJoin('event_proposals', 'event_proposals.id', '=', 'event_requests.event_proposals_id')
        ->leftJoin('events', 'events.id', '=', 'event_proposals.event_id')
        ->where('event_requests.is_active', 1)
        ->whereIn('state', [IEventStates::STATE_NEW, IEventStates::STATE_REJECTED])
        ->where(function($query) {
            $query->orWhere('event_proposals.user_id', Auth::user()->id);
            $query->orWhere('event_requests.user_id', Auth::user()->id);
        })
        ->orderBy('events.date', 'asc')
        ->get();
                
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }
    
    /**
     * Return upcoming events list for disabled user
     * @param Request $request
     * @return string
     */
    public function upcomingEvents(Request $request)
    {
        $events = EventRequest::with(['requestor', 'proposal' => function($query) {
            $query->with(['user']);
        }])
        ->select(
            '*',
            'event_requests.user_id AS requestor_user_id',
            \DB::raw('DATE_FORMAT(events.date, \'%d.%m.%Y\') AS date')
        )
        ->leftJoin('event_proposals', 'event_proposals.id', '=', 'event_requests.event_proposals_id')
        ->leftJoin('events', 'events.id', '=', 'event_proposals.event_id')
        ->where('event_requests.is_active', 1)
        ->where(function($query) {
            $query->orWhere('event_proposals.user_id', Auth::user()->id);
            $query->orWhere('event_requests.user_id', Auth::user()->id);
        })
        ->where('state', IEventStates::STATE_ACCEPTED)
        ->where('date', '>', date('Y-m-d H:i:s'))
        ->orderBy('events.date', 'asc')
        ->get();
                
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }
    
    /**
     * Event information on event accept page
     * @param int $requestId
     * @return string
     */
    public function requestOverview($requestId) 
    {
        $data = EventRequest::with(['user',
            'proposal' => function($query) {
                $query->with(['event' => function($query) {
                    $query->with(['category']);
                }]);
            }])
            ->where([
                'event_requests.id' => $requestId,
                'event_requests.is_active' => 1,
            ])
            ->first();
        
        if ($data === null) {
            return response()->json(['success' => false], 404);
        }
        
        return response()->json(['success' => true, 'data' => $data]);
    }
    
    /**
     * Event searching for autocomplete (during event adding)
     * @param AutocompleteRequest $request
     * @return string
     */
    public function autocomplete(Requests\AutocompleteRequest $request)
    {
        $keywords = preg_split('~\s+~', $request->input('keyword'));
        $events = Event::select('*');
        foreach ($keywords as $keyword) {
            $events
                ->where(function($query) use($keyword) {
                    $query->where('date', '>', date('Y-m-d H:i:s'));
                    $query->where(function($query) use($keyword) {
                        $query->orWhere('name', 'LIKE', sprintf('%%%s%%', $keyword));
                        $query->orWhere('destination', 'LIKE', sprintf('%%%s%%', $keyword));
                        $query->orWhere(DB::raw('DATE_FORMAT(`date`, \'%d.%m.%Y\')'), 'LIKE', sprintf('%%%s%%', $keyword));
                    });
                });
        }
        $events = $events->limit(100)->get();
        
        return response()->json(['success' => true, 'data' => $events]);
    }
    
    /**
     * Set event request state to accepted
     * @param int $requestId Event request id
     * @return string
     */
    public function eventAccept($requestId)
    {
        /** @var \App\Models\EventRequest|null $eventRequest */
        $eventRequest = EventRequest::with(['proposal' => function($query) {
            $query->with(['user']);
        }])
        ->where([
            'id' => $requestId,
            'state' => IEventStates::STATE_NEW
        ])
        ->first();
        
        if ($eventRequest === null) {
            return response()->json([
                'success' => false,
                'message' => 'Event request not found'
            ], 404);
        }
        
        if ($eventRequest->proposal === null) {
            return response()->json([
                'success' => false,
                'message' => 'Event does not have any proposals'
            ], 404);
        }
        
        if ($eventRequest->proposal->user->id !== Auth::user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'You have no permissions to accept this event'
            ], 409);
        }
        
        $eventRequest->update([
            'state' => IEventStates::STATE_ACCEPTED
        ]);
        
        return response()->json([
            'success' => true
        ]);
    }
    
    /**
     * Set event request state to declined
     * @param int $requestId Event request id
     * @return string
     */
    public function eventReject($requestId)
    {
        /** @var \App\Models\EventRequest|null $eventRequest */
        $eventRequest = EventRequest::where([
            'id' => $requestId,
            'state' => IEventStates::STATE_NEW
        ])
        ->first();
        
        if ($eventRequest === null) {
            return response()->json([
                'success' => false,
                'message' => 'Event request not found'
            ], 404);
        }
        
        $eventRequest->update([
            'state' => IEventStates::STATE_REJECTED
        ]);
        
        return response()->json([
            'success' => true
        ]);
    }
}
