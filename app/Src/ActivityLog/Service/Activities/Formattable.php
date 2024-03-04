<?php
namespace App\Src\ActivityLog\Service\Activities;

use App\Src\ActivityLog\Service\Formatter\CarbonFormatter;
use App\Src\ActivityLog\Service\Formatter\CustomFormatter;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use Carbon\Carbon;


trait Formattable
{



    protected function obtainDatetimeFormatter(Carbon $moment, string $title):CarbonFormatter{
        return new CarbonFormatter($title, $moment->toDateTimeString());
    }





    protected function obtainSessionOrderFormatter(SessionOrder $sessionOrder):CustomFormatter{
        return new CustomFormatter('Num. Session', $sessionOrder->get());
    }
}
