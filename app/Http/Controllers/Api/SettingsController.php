<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserSettingsRequest;

class SettingsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $code = 200;
        $status = true;
        
        $settings = UserSetting::where([
            'user_id' => Auth::user()->id
        ])
        ->get();
        
        return new Response(compact('status', 'settings'), $code);
    }
    
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSection(Request $request, $section)
    {
        $code = 200;
        $status =  true;
        
        $settings = UserSetting::where([
            'user_id' => Auth::user()->id,
            'section' => $section
        ])
        ->get();

        return new Response(compact('status', 'settings'), $code);
    }
    
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showByKey(Request $request, $key)
    {
        $status =  true;
        
        $setting = UserSetting::where([
            'user_id' => Auth::user()->id,
            'key' => $key
        ])
        ->first();
        
        if (!$setting) {
            return new Response([
                'status' => false,
                'error' => 'Parameter "' . $key . '" not found.'
            ], 404);
        }

        return new Response(compact('status', 'setting'), 200);
    }
    
    /**
     * Store the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateUserSettingsRequest $request)
    {
        $status = true;
        
        $setting = UserSetting::firstOrCreate([
            'user_id' => Auth::user()->id,
            'section' => $request->input('section'),
            'key' => $request->input('key')
        ]);
        
        $data = $request->all();
        
        // If record updates it's not neccessary to fill name field
        if (empty($data['name'])) 
        {
            unset($data['name']);
        }
        
        $setting->fill($data);
        $setting->save();
        
        return new Response(compact('status', 'setting'), 200);
    }
    
    /**
     * Remove the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $status = true;
        
        $setting = UserSetting::where([
            'user_id' => Auth::user()->id,
            'id' => $id
        ])
        ->first();
        
        if (!$setting) {
            return new Response([
                'status' => false,
                'error' => 'Setting not found.'
            ], 404);
        }
        
        $setting->delete();

        return new Response(compact('status'), 200);
    }
}
