<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
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

    public function publicProfile(Request $request, $id) 
    {
        $result = [
            'status' => true,
        ];
        $code = 200;
        
        $profile = User::with(['answers' => function($query) use ($id)  {
            $query->with(['question' => function($query) use ($id)  {
                $query->with(['question_privacy' => function($query) use ($id) {
                    $query->with(['users'])->where('user_id', $id);
                }]);
            }])
            ->where('answer_type', 1);
        }])
        ->where('id', $id)
        ->where('is_blocked', 0)
        ->first();
        
        if (!$profile) {
            $result = [
                'status' => false,
                'error' => 'User not found'
            ];
            $code = 404;
        }
        
        // Check if users connected to each other
        $is_connected = policy($profile)->isConnected($profile, Auth::user());
        
        $profile = $profile->toArray();
        
//        $profile['answers']= array_filter($profile['answers'], function($answer) use ($is_connected) {
//            switch ($answer['question']['question_privacy']['privacy_level']) {
//                case 1:
//                    return true;
//                break;
//            }
////            if ($answer['question']['question_privacy']['privacy_level'] === 1) {
////                return true;
////            }
//                    
//            return false;
//        });
        
//        dd($profile->toArray());
        
        $result['profile'] = $profile;
        
        return new Response($result, $code);
    }
}
