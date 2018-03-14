<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    public function __construct() {
        /**
         * Add following headers because of ajax requests goes from
         * another development server. Remove after React builder bundle
         * integrated to admin panel
         */
        //header('Access-Control-Allow-Credentials: true');
        //header('Access-Control-Allow-Origin: http://192.168.1.219:8888');
    }
    
    public function index(Request $request)
    {
        $questions = Question::whereNull('custom_type')->get();
        
        return new Response($questions, 200);
    }
}