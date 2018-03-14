<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::where(['enabled' => 1])
                ->orderBy('order', 'ASC')
                ->get();
        
        return new Response($podcast, 200);
    }
    
    public function remove(Request $request, $id) {
        // Check if category can be removed or not. 
        // If category can be removed HTTP 203 (or 200) error code should be returned
        // or any another (except 20X) otherwise
        
        //$category = Category::findOrFail($id)->delete();

        if (false) {
            $code = 203;
            $result = [
                'status' => true,
            ];
        }
        else {
            $code = 409;
            $result = [
                'status' => true,
            ];
        }
        
        return new Response($result, $code);
    }
}