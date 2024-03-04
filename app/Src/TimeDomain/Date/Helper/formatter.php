<?php

if (! function_exists('obtainTimezoneName')) {
    function obtainTimezoneName(string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {

        if (is_null($timezone)){
            return userTimezoneName();
        }

        if ($timezone instanceof \App\Src\Localization\TimeZone\Model\TimeZone){
            return $timezone->name;
        }

        return empty($timezone) ? userTimezoneName() : $timezone;
    }
}

if (! function_exists('toDatetimeInOneRow')) {
    function toDatetimeInOneRow(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null, bool $showTimezone = false)
    {
        $timezoneName = obtainTimezoneName($timezone);

        $result = $moment->clone()->setTimezone($timezoneName)->format('m/d/Y H:i:s');

        if ($showTimezone){
            $result.=' ('.$timezoneName.')';
        }

        return $result;
    }
}

if (! function_exists('toDatetimeInTwoRow')) {
    function toDatetimeInTwoRow(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        $moment = $moment->clone()->setTimezone($timezoneName);

        return $moment->format('m/d/Y').'<br>'.$moment->format('H:i:s');
    }
}

if (! function_exists('toDate')) {
    function toDate(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        return $moment->format('m/d/Y');

        $timezoneName = obtainTimezoneName($timezone);
        $moment = $moment->clone();
        return $moment->setTimezone($timezoneName)->format('m/d/Y');
    }
}

if (! function_exists('toTimeHm')) {
    function toTimeHm(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null )
    {
        $timezoneName = obtainTimezoneName($timezone);

        return $moment->clone()->setTimezone($timezoneName)->format('H:i');
    }
}

if (! function_exists('toTimeHms')) {
    function toTimeHms(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null )
    {
        $timezoneName = obtainTimezoneName($timezone);

        return $moment->clone()->setTimezone($timezoneName)->format('H:i:s');
    }
}

if (! function_exists('toTime24h')) {
    function toTime24h(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);

        return $moment->clone()->setTimezone($timezoneName)->format('h:i A');
    }
}

if (! function_exists('toMonthAndCardinalDay')) {
    //August 7th
    function toMonthAndCardinalDay(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        return $moment->clone()->setTimezone($timezoneName)->format('F jS');
    }
}

if (! function_exists('toMonthShortAndDay')) {
    //Feb, 13
    function toMonthShortAndDay(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        return $moment->clone()->setTimezone($timezoneName)->format('M, d');
    }
}

if (! function_exists('toDayMonthAndYear')) {
    //21 Aug, 2023
    function toDayMonthAndYear(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        return $moment->clone()->setTimezone($timezoneName)->format('d M, Y');
    }
}

if (! function_exists('toDayMonthAndYearWithHour')) {
    //26 Jun, 2023 17:30
    function toDayMonthAndYearWithHour(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        return $moment->clone()->setTimezone($timezoneName)->format('d M, Y H:i');
    }
}

if (! function_exists('toDayDateTimeString')) {
    //Mon, Aug 21, 2023 2:00 AM
    function toDayDateTimeString(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        $moment = $moment->clone();
        return $moment->setTimezone($timezoneName)->toDayDateTimeString();
    }
}

if (! function_exists('toFormattedDayDateString')) {
    //Thu, Jun 8, 2023
    function toFormattedDayDateString(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        $moment = $moment->clone();
        return $moment->setTimezone($timezoneName)->format('D, M d, Y');
    }
}

if (! function_exists('toMonthDayYear')) {
    //Oct 06 2023
    function toMonthDayYear(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        $moment = $moment->clone();
        return $moment->setTimezone($timezoneName)->format('M d Y');
    }
}


if (! function_exists('toDateExtend')) {
    //Wednesday 18th October 2023 - 3:00pm
    function toDateExtend(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        return $moment->clone()->setTimezone($timezoneName)->format('l jS F Y - g:ia');
    }
}

if (! function_exists('toMonthShortAndDay')) {
    //Feb, 13
    function toMonthShortAndDay(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        return $moment->clone()->setTimezone($timezoneName)->format('M, d');
    }
}

if (! function_exists('toDayMonthAndYear')) {
    //21 Aug, 2023
    function toDayMonthAndYear(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        return $moment->clone()->setTimezone($timezoneName)->format('d M, Y');
    }
}

if (! function_exists('toDayMonthAndYearWithHour')) {
    //26 Jun, 2023 17:30
    function toDayMonthAndYearWithHour(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        return $moment->clone()->setTimezone($timezoneName)->format('d M, Y H:i');
    }
}

if (! function_exists('writeMonth')) {
    //August 21st 2023
    function writeMonth(App\Src\TimeDomain\Month\Service\Month $month)
    {
        $period = $month->period()->getStartDate();

        return $period->format('F');
    }
}

if (! function_exists('toMonthDayAndYear')) {
    //September 08, 2023
    function toMonthDayAndYear(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        return $moment->clone()->setTimezone($timezoneName)->format('F d, Y');
    }
}

if (! function_exists('toMonthDayAndYearExtend')) {
    //August 30, 2023 - 10:00 AM
    function toMonthDayAndYearExtend(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        return $moment->clone()->setTimezone($timezoneName)->format('F d, Y - g:i A');
    }
}


if (! function_exists('toMonthDayAndYearExtendShort')) {
    //August 30, 2023 - 10:00 AM
    function toMonthDayAndYearExtendShort(Carbon\Carbon $moment, string|\App\Src\Localization\TimeZone\Model\TimeZone $timezone = null)
    {
        $timezoneName = obtainTimezoneName($timezone);
        return $moment->clone()->setTimezone($timezoneName)->format('M d, Y - g:i A');
    }
}
