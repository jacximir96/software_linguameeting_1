<?php


namespace App\Src\ActivityLog\Service\Formatter;


use App\Src\ActivityLog\Service\Activities\Properties;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class FormatterBuilder
{


    public function buildFormatters (Properties $properties):Collection{

        $formatters = new Collection();

        foreach ($properties->get() as $property){
            $formatters->push($this->buildProperty($property));
        }

        return $formatters;
    }

    public function sessionOrderFormatter (SessionOrder $sessionOrder):CustomFormatter{
        return new CustomFormatter('Session Order', $sessionOrder->get());
    }

    public function courseFormatter(Course $course):CustomFormatter{
        return new CustomFormatter('Course', $course->name);
    }

    public function sectionFormatter(Section $section):CustomFormatter{
        return new CustomFormatter('Section', $section->name);
    }

    public function makeupFreeFormatter(Makeup $makeup):CustomFormatter{

        $value = $makeup->isFree() ? 'Yes' : 'No';

        return new CustomFormatter('Is Free?', $value);
    }

    public function makeupTypeFormatter(Makeup $makeup):CustomFormatter{
        return new CustomFormatter('Type', $makeup->type->name);
    }

    private function buildProperty (array $property):Formatter{

        return match ($property['type']){

            'datetime' => new CarbonFormatter($property['title'], $property['value']),

            'enrollment' => $this->buildEnrollmentFormatter($property),

            'enrollment_session' => $this->buildEnrollmentSessionFormatter($property),

            'ip' => new CustomFormatter($property['title'], $property['value']),

            'section' => $this->buildSectionFormatter($property),

            'session' => $this->buildSessionFormatter($property),

            'user' => $this->buildUserFormatter($property),

            default => new CustomFormatter($property['title'], '')
        };

    }

    private function buildEnrollmentFormatter (array $property):CustomFormatter{

        $enrollment = Enrollment::withTrashed()->find($property['id']);

        return new CustomFormatter($property['title'], $enrollment->course()->name);

    }

    private function buildEnrollmentSessionFormatter (array $property):CustomFormatter{

        $enrollmentSession = EnrollmentSessionRepository::findTrashed($property['id']);

        return new CustomFormatter($property['title'], $enrollmentSession->enrollment->course()->name);

    }

    private function buildSectionFormatter (array $property):CustomFormatter{

        $section = SectionRepository::findTrashed($property['id']);

        return new CustomFormatter($property['title'], $section->name);

    }

    private function buildSessionFormatter (array $property):CustomFormatter{

        $session = SessionRepository::findTrashed($property['id']);

        $value = $session->scheduleSession()->start()->toDatetimeString();

        return new CustomFormatter($property['title'], $value);

    }

    private function buildUserFormatter (array $property):CustomFormatter{

        $user = User::withTrashed()->find($property['id']);

        return new CustomFormatter($property['title'], $user->writeFullName());

    }
}
