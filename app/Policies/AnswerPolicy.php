<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\Podcast;
use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Answer $answer
     * @param User $user
     * @return bool
     */
    public function isViewableBy(Answer $answer, User $user)
    {
        return $user->id === $answer->user_id;
    }

    /**
     * @param Answer $answer
     * @param User $user
     * @return bool
     */
    public function isCreatableBy(Answer $answer, User $user)
    {
        if (!$user->podcast) {
            return false;
        }
        $question = Question::find($answer->question_id);
        if (!$question) {
            return false;
        }

        return (bool) sizeof(array_intersect(
            $question->categories()->get()->pluck('id')->toArray(),
            $user->podcast->categories()->get()->pluck('id')->toArray()
        ));
    }

    public function isAllowedFor(Answer $answer, Question $question, User $user)
    {
        /**
         * @todo Validate params and value
         */
        return true;
    }
}
