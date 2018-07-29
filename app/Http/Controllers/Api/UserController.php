<?php

namespace App\Http\Controllers\Api;


use App\Exceptions\WrongSettingsException;
use App\Interfaces\IState;
use App\Models\User;
use App\Models\UserSetting;
use App\Models\UserConnection;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\IUserSettings;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     * Deactivate user account
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     * @throws WrongSettingsException
     */
    public function updateProgress(Requests\UpdateUserProgressRequest $request, $progress)
    {
        $data = $request->only(['section', 'value']);

        Auth::user()->update([
            'progress' => $progress
        ]);
        
        // Save settings
        if (!empty($data['section'])) {
            UserSetting::apply($data['section'], $data['value']);
        }
        
        return response()->json([
            'success' => true,
            'user' => Auth::user(),
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws WrongSettingsException
     */
    public function profilePhoto(Request $request) 
    {
        /** @var string $path */
        $path = $request->file('profile-photo')->store('profile-photos');
        
        /** Update user profile photo */
        UserSetting::apply(IUserSettings::PROFILE_PHOTO, $path);
        
        return response()->json([
            'status' => true,
            'user' => User::find(Auth::user()->id)
        ]);
    }

    
    /**
     * Get user information
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentUser()
    {
        return response()->json([
            'status' => true,
            'data' => Auth::user()
        ]);
    }


    /**
     * @param int $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function profileInfo(int $user)
    {
        /** @var User $profile */
        $profile = User::with(['reviews' => function($query) {
            $query
                ->with(['reviewer'])
                ->where('is_active', IState::ACTIVE)
                ->orderBy('id', 'DESC')
                ->limit(5);
        }])
        ->find($user);

        if ($profile === null) {
            return response()->json([
                'status' => false,
                'message' => 'Profile not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $profile
        ]);
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


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws WrongSettingsException
     */
    public function updateDisabilityInfo(Request $request)
    {
        $request->validate([
            'disability_information' => 'required|string|min:10'
        ]);

        UserSetting::apply(
            IUserSettings::PROFILE_DISABILITY_INFORMATION,
            $request->input('disability_information')
        );

        return response()->json([
            'success' => true,
            'message' => 'Information updated',
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws WrongSettingsException
     */
    public function updateRequireAssistance(Request $request)
    {
        $request->validate([
            'require_assistance' => 'required|string|min:10'
        ]);

        UserSetting::apply(
            IUserSettings::PROFILE_REQUIRE_ASSISTANCE,
            $request->input('require_assistance')
        );

        return response()->json([
            'success' => true,
            'message' => 'Information updated',
        ]);
    }
}
