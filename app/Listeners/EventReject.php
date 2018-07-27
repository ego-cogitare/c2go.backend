<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 7/27/18
 * Time: 10:11 PM
 */

namespace App\Listeners;


use App\Interfaces\IEventStates;
use App\Interfaces\IAccountType;
use Illuminate\Support\Facades\Auth;
use App\Models\EventRequest;

/**
 * Class EventReject
 * @package App\Listeners
 */
class EventReject
{
    public function handle(EventRequest $eventRequest)
    {
        if (Auth::user()->getAccountType() !== IAccountType::DISABLED) {
            throw new \Exception('Only disabled people can reject event requests.');
        }

        /** Mark event request as rejected */
        $eventRequest->update([
            'state' => IEventStates::STATE_REJECTED
        ]);
    }
}