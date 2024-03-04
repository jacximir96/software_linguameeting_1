<?php
if ( ! function_exists('userTimezoneName')) {

    function userTimezoneName()
    {
        $user = user();

        if ($user){
            return $user->timezone->name;
        }

        return config('app.timezone');
    }
}

if ( ! function_exists('userTimezone')) {

    function userTimezone()
    {
        $user = user();

        if ($user){
            return $user->timezone;
        }

        return \App\Src\Localization\TimeZone\Repository\TimeZoneRepository::findByName(config('app.timezone'));
    }
}
