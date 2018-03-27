<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $result = Category::with(['categories'])
            ->where('is_active', 1)
            ->whereNull('parent_id')
            ->orderBy('order', 'ASC')
            ->get();
            
        return response()->json([
            'success' => true, 
            'data' => $result
        ]);
    }
}
