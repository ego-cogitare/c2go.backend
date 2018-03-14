<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckController extends Controller
{
    public function restricted(Requests\CheckRestrictedRequest $request)
    {
        return ['email' => Auth::user()->email];
    }

}
