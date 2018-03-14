<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use App\Models\Podcast;

class PodcastController extends Controller
{
    public function index(Request $request)
    {
        return ['list' => Podcast::where('enabled', true)->get()];
    }

    public function show($id)
    {
        $code = 200;
        $podcast = Podcast::with([
            'categories' => function($query) {
                $query->with([
                    'category_questions' => function($query) {
                        $query->with(['question'])->orderBy('order', 'ASC');
                    },
                    'question_params' => function($query) {

                    },
                ])->where('type', Category::TYPE_CATEGORY)->orderBy('order', 'ASC');
            }
        ])
        ->find($id);
        
        if (!$podcast) {
            $result = [
                'status' => false,
                'error' => 'Podcast not found'
            ];
            $code = 404;
        } else {
            $result = [
                'status' => true,
                'podcast' => $podcast
            ];
        }

        return new Response($result, $code);
    }

    public function categories($id)
    {
        $code = 200;
        $podcast = Category::where([
            'podcast_id' => $id, 
            'type' => Category::TYPE_CATEGORY, 
            'enabled' => true,
        ])->get();
        
        if (!$podcast) {
            $result = [
                'status' => false,
                'error' => 'Podcast not found'
            ];
            $code = 404;
        } else {
            $result = [
                'status' => true,
                'list' => $podcast
            ];
        }

        return new Response($result, $code);
    }

    public function criterias($id)
    {
        $code = 200;
        $podcast = Category::where([
            'podcast_id' => $id, 
            'type' => Category::TYPE_CRITERIA, 
            'enabled' => true
        ])->get();
        
        if (!$podcast) {
            $result = [
                'status' => false,
                'error' => 'Podcast not found'
            ];
            $code = 404;
        } else {
            $result = [
                'status' => true,
                'list' => $podcast
            ];
        }

        return new Response($result, $code);
    }
}
