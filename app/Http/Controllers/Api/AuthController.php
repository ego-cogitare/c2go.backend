<?php

namespace App\Http\Controllers\Api;

//use App\Events\NotificationEvent;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials, ['is_blocked' => false])) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
            $user = User::with(['settings'])->find(JWTAuth::toUser($token)->id);
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        
        return response()->json(compact('token', 'user'));
    }


    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        //$notifications = Notification::counts($user);

        //return response()->json(compact('user', 'notifications'));
        return response()->json(compact('user'));
    }

    public function refreshToken(Request $request)
    {
        try {
            if (!$token = JWTAuth::refresh($request->token)) {
                return response()->json(['error' => 'token_invalid'], 400);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('token'));
    }

    /**
     * Check if all required field for registration with email are correct
     */
    public function userValidation(Requests\AuthRegistrationRequest $request)
    {
        return response()->json(['valid' => true]);
    }
    
    /**
     * Registration via email
     */
    public function registration(Requests\AuthRegistrationRequest $request)
    {
        $data = $request->all();
        
        // Set user registration progress to 1 (email needs to be confirmed)
        $data['progress'] = 2;
        
//        Mail::send('emails.confirmation', ['email' => $data['email']], function($message) use($data) {
//            $message->to($data['email'], 'xxx')
//                    ->subject('Email confirmaion');
//        });
        
        $user = User::create($data);
        $token = JWTAuth::fromUser($user);
        $user = User::with(['settings'])->find($user->id);
        
        // Save user location to user settings table
        UserSetting::location($user->id, $data['location']);
        
        //event(new NotificationEvent($user, 'Add your first broker', ['type' => 'first broker']));
        return response()->json(compact('token', 'user'));
    }

    public function forgotPassword(Requests\AuthForgotRequest $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        $password = str_random(6);
        $user->password = $password;
        $user->save();
        try {
            /**
             * @todo Send email here
             */
            /*
            Mail::send('emails.forgot', array('password' => $password), function ($message) use ($user) {
                $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Forgot password');
            });
            */
            $status = true;
        } catch (\Exception $ex) {
            Log::error($ex);
            $status = false;
        }
        return response()->json(['status' => $status]);
    }
    
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request, $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function social(Request $request, $provider)
    {
        $socialUser = Socialite::driver($provider)->userFromToken($request->input('token'));
        if ($socialUser) {
            $user = User::where('email', $socialUser->email)->first();
            if ($user) {
                $token = JWTAuth::fromUser($user, ['is_blocked' => false]);
                //$notifications = Notification::counts($user);
                //return response()->json(compact('token', 'user', 'notifications'));
                return response()->json(compact('token', 'user'));
            }
        }
        return new Response([
            'status' => false,
            'error' => 'Forbidden'
        ], 403);
    }
}
