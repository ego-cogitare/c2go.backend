<?php

namespace App\Policies;

use App\Models\Testimonial;
use App\Models\User;

class TestimonialPolicy
{
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
     * @param Testimonial $testimonial
     * @param User $user
     * @return boolean
     */
    public function isCreatableBy(User $user, Testimonial $testimonial)
    {
        // Some bussiness logic to define whatever user has rights
        // to add new testimonial

        return true;
    }
}
