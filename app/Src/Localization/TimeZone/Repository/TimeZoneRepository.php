<?php

namespace App\Src\Localization\TimeZone\Repository;

use App\Src\Localization\TimeZone\Model\TimeZone;

class TimeZoneRepository
{
    public function findTimezoneByNameOrNull(string $name): TimeZone
    {
        return TimeZone::where('name', $name)->first();
    }

    public static function findByName(string $name): TimeZone
    {
        return TimeZone::where('name', $name)->first();
    }

    public static function findById(int $id): TimeZone
    {
        return TimeZone::find($id);
    }
}
