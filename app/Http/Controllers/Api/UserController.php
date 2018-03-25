<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserSetting;
use App\Models\UserConnection;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $code = 200;
        $user = User::find($id);
        if (!$user) {
            $result = [
                'status' => false,
                'error' => 'User not found'
            ];
            $code = 404;
        } else {
            $result = [
                'status' => true,
                'user' => $user
            ];
        }

        return new Response($result, $code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateUserRequest $request, $id)
    {
        $code = 200;
        /** @var User $user */
        $user = User::find($id);
        if (!$user) {
            $result = [
                'status' => false,
                'error' => 'User not found'
            ];
            $code = 404;
        } else {
            if (policy($user)->update(Auth::user(), $user)) {
                $data = $request->all();
                $user->update($data);
                $user = User::find($id);
                $result = [
                    'status' => true,
                    'user' => $user
                ];
            } else {
                $result = [
                    'status' => false,
                    'error' => 'Forbidden'
                ];
                $code = 403;
            }

        }

        return new Response($result, $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $code = 200;
        $user = User::find($id);
        if (!$user) {
            $result = [
                'status' => false,
                'error' => 'User not found'
            ];
            $code = 404;
        } else {
            if (policy($user)->delete(Auth::user(), $user)) {
                $user->delete();
                $result = [
                    'status' => true,
                ];
            } else {
                $result = [
                    'status' => false,
                    'error' => 'Forbidden'
                ];
                $code = 403;
            }
        }

        return new Response($result, $code);
    }

    public function block($id)
    {
        $code = 200;
        $user = User::find($id);
        if (!$user) {
            $result = [
                'status' => false,
                'error' => 'User not found'
            ];
            $code = 404;
        } else {
            if (policy($user)->update(Auth::user(), $user)) {
                $user->is_blocked = !$user->is_blocked;
                $user->save();
                $result = [
                    'status' => true,
                    'user' => $user
                ];
            } else {
                $result = [
                    'status' => false,
                    'error' => 'Forbidden'
                ];
                $code = 403;
            }
        }

        return new Response($result, $code);
    }
    
    public function updateProgress(Requests\UpdateUserProgressRequest $request, $progress)
    {
        Auth::user()->progress = $progress;
        Auth::user()->save();
        
        $data = $request->only(['section', 'value']);
        
        // Save setting
        if (!empty($data['section'])) {
            UserSetting::apply(Auth::user()->id, $data['section'], $data['value']);
        }
        
        return new Response(['user' => Auth::user()]);
    }
    
    public function profilePhoto(Request $request) 
    {
        $path = $request->file('profile-photo')->store('profile-photos');
        
        // Update user profile photo
        UserSetting::apply(Auth::user()->id, 'profile_photo', $path);
        
        return response()->json([
            'status' => true,
            'user' => User::with(['settings'])->find(Auth::user()->id)
        ]);
    }
}
