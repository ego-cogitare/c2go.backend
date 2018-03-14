<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use App\Models\QuestionPrivacy;
use App\Models\QuestionPrivacyUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function show($id)
    {
        $code = 200;
        
        $question = Question::with([
            'question_privacy' => function($query) {
                $query->with(['users'])->where('user_id', Auth::user()->id);
            }
        ])
        ->find($id);
        
        if (!$question) {
            $result = [
                'status' => false,
                'error' => 'Question not found'
            ];
            $code = 404;
        } else {
            $result = [
                'status' => true,
                'question' => $question
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
    public function privacyUpdate(Requests\UpdateQuestionPrivacyRequest $request, $id)
    {
        $question = Question::find($id);
        
        if (!$question) {
            $result = [
                'status' => false,
                'error' => 'Question not found'
            ];
            return new Response($result, 404);
        }
        
        $privacy = QuestionPrivacy::firstOrCreate([
            'question_id' => $id, 
            'user_id' => Auth::user()->id
        ]);
        $privacy->question_id = $id;
        $privacy->user_id = Auth::user()->id;
        $privacy->privacy_level = $request->privacy_level;
        $privacy->save();
        
        $privacy_users = $request->input('privacy_users');
        if (sizeof($privacy_users) > 0) {
            foreach ($privacy_users as $privacy_user) {
                QuestionPrivacyUsers::create([
                    'qp_id' => $privacy->id, 
                    'user_id' => $privacy_user
                ]);
            }
        }
        
        $result = [
            'status' => true,
            'privacy' => $privacy
        ];

        return new Response($result, 200);
    }
}
