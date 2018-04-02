<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\EventProposal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventsController extends Controller
{
    const RIDE_CATEGORY_IDS = [4];
    
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
            $events = Event::with(['category', 'user' => function($query) {
                    $query->with(['settings']);
                }])
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
                $query->with([
                    'settings', 
                    'prices' => function($query) use($id) {
                        $query->where('event_id', $id);
                    }
                ]);
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
    
    public function requests($event, $user)
    {
        $event = EventProposal::with([
            'event' => function($query) use($user) {
                $query->with([
                    'requests' => function($query) use($user) {
                        $query->with(['user' => function($query) {
                            $query->with(['settings']);
                        }])
                        ->where('event_user_id', $user);
                    },
                    'category' => function($query) {
                        $query->with(['parent']);
                    }
                ]);
            }, 
            'user' => function($query) {
                $query->with('settings');
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
}
