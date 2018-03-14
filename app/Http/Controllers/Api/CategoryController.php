<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function show($id)
    {
        $code = 200;
        
        $category = Category::with([
            'category_questions' => function($query) {
                $query->with([
                    'question' => function($query) {
                        $query->with([
                            'question_privacy' => function($query) {
                                $query->with(['users'])->where('user_id', Auth::user()->id);
                            }
                        ]);
                    }
                ]);
            },
            'question_params' => function($query) {
            }
        ])
        ->find($id);
        
        if (!$category) {
            $result = [
                'status' => false,
                'error' => 'Category not found'
            ];
            $code = 404;
        } else {
            $result = [
                'status' => true,
                'category' => $category
            ];
        }

        return new Response($result, $code);
    }
}
