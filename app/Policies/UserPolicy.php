<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserConnection;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function update(User $user, User $userUpdate)
    {
        return $user->id === $userUpdate->id;
    }

    public function delete(User $user, User $userDelete)
    {
        return $user->id === $userDelete->id;
    }
    
    public function isConnected(User $user1, User $user2)
    {
        $connection = UserConnection::where(function($query) use ($user1, $user2) {
            $query->where([
                'user1_id' => $user1->id, 
                'user2_id' => $user2->id
            ]);
        })
        ->orWhere(function($query) use ($user1, $user2) {
            $query->where([
                'user1_id' => $user2->id,
                'user2_id' => $user1->id, 
            ]);
        })
        ->first();
        
        return (bool)$connection;
    }
}
