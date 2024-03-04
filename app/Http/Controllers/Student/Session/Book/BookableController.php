<?php
namespace App\Http\Controllers\Student\Session\Book;

use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Carbon\Carbon;


trait BookableController
{

    public function cleanSession (){
        session()->remove('isReschedule');
        session()->remove('isMakeup');
        session()->remove('isExtraSession');
        session()->remove('coachingWeekIdInExtraSession');

    }

    //datos a la vista para poder hacer llamadas api y cargar calendarios...etc.
    public function sendDataForApiCallToView(Enrollment $enrollment, SessionOrder $sessionOrder, array $config = [], bool $isMakeupWeek){

        $config['sessionOrder'] = $sessionOrder;

        if ($enrollment->course()->isFlex()){
            $config['startDate'] = $enrollment->course()->start_date;
            $config['endDate'] = $enrollment->course()->end_date;
            $config['urlApiShowFormSearch'] = route('get.student.api.session.get.flex', [$enrollment->hashId(), $sessionOrder->get(), 'isCreateBook' => true]);
        }
        else{

            $coachingWeek = null;

            if ($isMakeupWeek){

                if (request()->has('dateSession')){

                    $dateSession = Carbon::parse(request()->get('dateSession'));

                    $coachingWeek = $enrollment->course()->obtainCoachingWeekFromDate($dateSession);
                }
            }

            if ( !$isMakeupWeek OR is_null($coachingWeek)){
                $coachingWeek = $enrollment->course()->obtainCoachingWeekBySessionOrder($sessionOrder);
            }

            $config['coachingWeek'] = $coachingWeek;
            $config['startDate'] = $coachingWeek->start_date;
            $config['endDate'] = $coachingWeek->end_date;
            $config['urlApiShowFormSearch'] = route('get.student.api.session.get.coaching_week', [$enrollment->hashId(), $sessionOrder->get(), 'isCreateBook' => true]);
        }

        view()->share($config);
    }
}
