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
    
    public function details(Request $request, $event, $user)
    {
        $limit = $request->get('limit', 5);
        $offset = $request->get('offset', 0);
        
        $event = EventProposal::with([
            'event' => function($query) use($user) {
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
        ->where([
            'event_id' => $event,
            'user_id' => $user,
        ])
        ->first();
        
        if (empty($event)) {
            return response()->json(['success' => false], 404);
        }
        
        return response()->json([
            'success' => true, 
            'data' => $event
        ]);
    }
    
    public function general($event, $user)
    {
        $event = EventProposal::with([
            'event' => function($query) use($user) {
                $query->with([
                    'category' => function($query) {
                        $query->with(['parent']);
                    }
                ]);
            }, 
            'user',
        ])
        ->where([
            'event_id' => $event,
            'user_id' => $user,
        ])
        ->first();
        
        if (empty($event)) {
            return response()->json(['success' => false], 404);
        }
        
        return response()->json([
            'success' => true, 
            'data' => $event
        ]);
    }
    
    public function storeRequest(Request $request, $event, $user)
    {
        $request->request->add([
            'event_user_id' => intval($user), 
            'event_id' => intval($event),
            'user_id' => Auth::user()->id,
        ]);
        
        $data = $request->all();
        
        $request->validate([
            'event_user_id' => 'required|integer|exists:users,id',
            'user_id' => 'required|integer|exists:users,id',
            'event_id' => 'required|integer|exists:events,id',
            'message' => 'required|string|min:10|max:120',
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
        $events = EventRequest::with(['user'])
            ->select(
                'event_requests.id', 
                'event_requests.state',
                'event_requests.message',
                'event_requests.user_id',
                'event_requests.event_user_id',
                \DB::raw('DATE_FORMAT(events.date, \'%d.%m.%Y\') AS date')
            )
            ->leftJoin('events', 'events.id', '=', 'event_requests.event_id')
            ->where('event_requests.is_active', 1)
            ->where('event_requests.event_user_id', Auth::user()->id)
            ->orderBy('events.date', 'asc')
            ->get();
                
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }
    
    public function showEventAccept($event) 
    {
        $data = EventRequest::with(['author', 'user', 'event' => function($query) {
                $query->with('category');
            }])
            ->select(
                'event_requests.*', 
                'event_proposals.price', 
                'event_proposals.message as request_message'
            )
            ->leftJoin('event_proposals', function($join) {
                $join->on('event_proposals.user_id', '=', 'event_requests.event_user_id');
                $join->on('event_proposals.event_id', '=', 'event_requests.event_id');
            })
            ->where([
                'event_requests.id' => $event,
                'event_requests.is_active' => 1,
                'event_requests.event_user_id' => Auth::user()->id
            ])
            ->first();
        
        if (empty($data)) {
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
                        $query->orWhere('event_location_human', 'LIKE', sprintf('%%%s%%', $keyword));
                        $query->orWhere(DB::raw('DATE_FORMAT(`date`, \'%d.%m.%Y\')'), 'LIKE', sprintf('%%%s%%', $keyword));
                    });
                });
        }
        $events = $events->limit(100)->get();
        
        return response()->json(['success' => true, 'data' => $events]);
    }
}
