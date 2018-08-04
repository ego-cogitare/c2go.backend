<?php

namespace App\Http\Controllers\Api;


use App\Exceptions\WrongSettingsException;
use App\Interfaces\IAccountType;
use App\Interfaces\IState;
use App\Models\User;
use App\Models\UserSetting;
use App\Models\UserConnection;
use App\Models\EventRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\IUserSettings;
use App\Models\UserReview;
use Illuminate\Support\Facades\Gate;
use Event as EventDispatcher;

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


    /**
     * @param Requests\VoteRequest $request
     * @param $requestId
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeVote(Requests\VoteRequest $request, $requestId)
    {
        /** @var EventRequest|null $eventRequest */
        $eventRequest = EventRequest::with(['proposal'])
            ->where('id', $requestId)
            ->where('is_active', IState::ACTIVE)
            ->first();

        if ($eventRequest === null) {
            return response()->json([
                'success' => false,
                'message' => 'Request not found'
            ], 404);
        }

        /**
         * Check if user has anought right to vote on this event request
         * @var array|bool $reviewGate
         */
        if (Gate::allows('vote:write', $eventRequest)) {
            /** @var int $userAboutId */
            $userAboutId = Auth::user()->getAccountType() === IAccountType::NORMAL
                ? $eventRequest->proposal->user_id
                : $eventRequest->user_id;

            /** @var UserReview $userReview */
            $userReview = UserReview::create([
                'mark' => $request->input('mark'),
                'user_about_id' => $userAboutId,
                'user_id' => Auth::user()->id,
                'event_id' => $eventRequest->proposal->event->id,
            ]);

            /** Broadcast vote received event (to send notifications) */
            EventDispatcher::fire('vote.lived', $userReview);

            return response()->json([
                'success' => true,
                'message' => 'Your vote saved'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'You have no right to live vote for this user and event'
        ], 403);
    }
}
