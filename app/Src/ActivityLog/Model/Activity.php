<?php
namespace App\Src\ActivityLog\Model;

use App\Src\ActivityLog\Service\Activities\BuyMakeupActivity;
use App\Src\ActivityLog\Service\Activities\CancelSessionActivity;
use App\Src\ActivityLog\Service\Activities\CourseSendDocumentationActivity;
use App\Src\ActivityLog\Service\Activities\LastMinuteSessionActivity;
use App\Src\ActivityLog\Service\Activities\LoginActivity;
use App\Src\ActivityLog\Service\Activities\LogoutActivity;
use App\Src\ActivityLog\Service\Activities\NewMakeupActivity;
use App\Src\ActivityLog\Service\Activities\NewSessionWithExtraSessionActivity;
use App\Src\ActivityLog\Service\Activities\NewSessionWithMakeupActivity;
use App\Src\ActivityLog\Service\Activities\Properties;
use App\Src\ActivityLog\Service\Activities\RescheduleSessionActivity;
use App\Src\ActivityLog\Service\Activities\SectionSendDocumentationActivity;
use App\Src\ActivityLog\Service\Activities\StudentChangeCourseActivity;
use App\Src\ActivityLog\Service\Activities\StudentChangeSectionActivity;
use App\Src\ActivityLog\Service\Activities\StudentCourseRefundActivity;


class Activity extends \Spatie\Activitylog\Models\Activity
{

    public function properties ():Properties{
        return new Properties($this->properties);
    }

    public function trans():string{
        return trans('log.'.$this->description);
    }

    public function buildActivity ():\App\Src\ActivityLog\Service\Activities\Activity{


        if ($this->description == config('linguameeting_log.activity.keys.student.create')){
            return new LogoutActivity($this);
        }
        elseif ($this->description == config('linguameeting_log.activity.keys.student.sessions.makeup.use_in_session')){
            return new NewSessionWithMakeupActivity($this);
        }


        elseif ($this->description == config('linguameeting_log.activity.keys.student.makeup.buy')){
            return new BuyMakeupActivity($this);
        }



        elseif ($this->description == config('linguameeting_log.activity.keys.course.makeup.create')){
            return new NewMakeupActivity($this);
        }
        elseif ($this->description == config('linguameeting_log.activity.keys.course.send_documentation')){
            return new CourseSendDocumentationActivity($this);
        }
        elseif ($this->description == config('linguameeting_log.activity.keys.section.makeup.create')){
            return new NewMakeupActivity($this);
        }

        elseif ($this->description == config('linguameeting_log.activity.keys.student.course.change')){
            return new StudentChangeCourseActivity($this);
        }
        elseif ($this->description == config('linguameeting_log.activity.keys.student.course.refund')){
            return new StudentCourseRefundActivity($this);
        }
        elseif ($this->description == config('linguameeting_log.activity.keys.student.section.change')){
            return new StudentChangeSectionActivity($this);
        }
        elseif ($this->description == config('linguameeting_log.activity.keys.section.send_documentation')){
            return new SectionSendDocumentationActivity($this);
        }
        elseif ($this->description == config('linguameeting_log.activity.keys.student.sessions.reschedule')){
            return new RescheduleSessionActivity($this);
        }
        elseif ($this->description == config('linguameeting_log.activity.keys.student.sessions.cancel')){
            return new CancelSessionActivity($this);
        }
        elseif ($this->description == config('linguameeting_log.activity.keys.student.sessions.last_minute')){
            return new LastMinuteSessionActivity($this);
        }
        elseif ($this->description == config('linguameeting_log.activity.keys.student.sessions.extra_session')){
            return new NewSessionWithExtraSessionActivity($this);
        }

        elseif ($this->description == config('linguameeting_log.activity.keys.user.login')){
            return new LoginActivity($this);
        }
        elseif ($this->description == config('linguameeting_log.activity.keys.user.logout')){
            return new LogoutActivity($this);
        }

        dd($this);
    }
}
