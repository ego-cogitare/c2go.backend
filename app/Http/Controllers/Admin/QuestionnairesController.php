<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionnairesController extends Controller
{
    public function category(Request $request)
    {
        
        return view('admin.questionnaires.index', ['type' => 1]);
    }
    
    public function cryteria(Request $request)
    {
        
        return view('admin.questionnaires.index', ['type' => 2]);
    }
}