<?php

namespace App\Interfaces;


/**
 * Interface IUserSettings
 * @package App\Interfaces
 */
interface IUserSettings
{
    /** @var string */
    const PROFILE_PHOTO = 'profile_photo';

    /** @var string */
    const PROFILE_HOME_LOCATION = 'location';

    /** @var array */
    const PROFILE_INTERESTS = 'profile_interests';

    /** @var string */
    const PROFILE_TYPE = 'profile_type';

    /** @var string */
    const PROFILE_PHONE = 'phone';

    /** @var string */
    const PROFILE_SETTINGS_GENERAL = 'profile_settings';

    /** @var string */
    const PROFILE_DISABILITY_INFORMATION = 'disability_information';

    /** @var string */
    const PROFILE_REQUIRE_ASSISTANCE = 'require_assistance';
}


