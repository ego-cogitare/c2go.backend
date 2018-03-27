<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $result = [];
        
        for ($i = 1; $i >= 0; $i--) 
        {
            $events = Event::with(['category', 'user' => function($query) {
                    $query->with(['settings']);
                }])
                ->where('is_top', $i)
                ->where('is_active', 1)
                ->where('date', '>', date('Y-m-d H:i:s'))
                ->orderBy('date', 'ASC')
                ->get();

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
}
