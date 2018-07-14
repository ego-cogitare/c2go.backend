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

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     * Deactivate user account
     * @return Response
     */
    public function deactivate()
    {
        Auth::user()->update(['is_blocked' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Account deactivated'
        ]);
    }


    /**
     * @param Requests\UpdateUserProgressRequest $request
     * @param $progress
     * @return Response
     */
    public function updateProgress(Requests\UpdateUserProgressRequest $request, $progress)
    {
        Auth::user()->update(['progress' => $progress]);

        $data = $request->only(['section', 'value']);
        
        // Save settings
        if (!empty($data['section'])) {
            UserSetting::apply(Auth::user()->id, $data['section'], $data['value']);
        }
        
        return new Response(['user' => Auth::user()]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profilePhoto(Request $request) 
    {
        $path = $request->file('profile-photo')->store('profile-photos');
        
        // Update user profile photo
        UserSetting::apply(Auth::user()->id, 'profile_photo', $path);
        
        return response()->json([
            'status' => true,
            'user' => User::find(Auth::user()->id)
        ]);
    }
    
    /**
     * Get user information
     * @param Request $request
     * @param type $user
     * @return void
     */
    public function profileInfo(Request $request, $user) 
    {
        $data = User::find($user);
        
        if (!$data) {
            $result = [
                'status' => false,
                'error' => 'User not found'
            ];
            $code = 404;
        } else {
            $result = [
                'status' => true,
                'data' => $data
            ];
            $code = 200;
        }
        
        return new Response($result, $code);
    }


    /**
     * @param Requests\ChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Requests\ChangePasswordRequest $request)
    {
        if (\Hash::check($request->input('old_password'), Auth::user()->getAuthPassword()) === false) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'old_password' => ['Old password does not match']
                ]
            ], 422);
        }

        Auth::user()->update(['password' => $request->input('new_password')]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed'
        ]);
    }
}
