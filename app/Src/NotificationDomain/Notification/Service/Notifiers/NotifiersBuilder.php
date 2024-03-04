<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers;

use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\CoachingWeeksNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\ConversationGuideNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\ConversationPackageNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\CourseCreatedNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\CourseDatesNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\DiscountNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\HolidaysNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\IsFreeNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\LanguageNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\NameNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\SemesterNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\StudentClassNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment\CourseChangedNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Section\InstructorNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Section\SectionCreatedNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment\SectionChangedNotifier;



class NotifiersBuilder
{

    public function build(string $key):Notifier{

        return match ($key){

            //course
            CourseCreatedNotifier::KEY => app(CourseCreatedNotifier::class),
            CourseDatesNotifier::KEY => app(CourseDatesNotifier::class),
            SemesterNotifier::KEY => app(SemesterNotifier::class),
            NameNotifier::KEY => app(NameNotifier::class),
            LanguageNotifier::KEY => app(LanguageNotifier::class),
            ConversationGuideNotifier::KEY => app(ConversationGuideNotifier::class),
            IsFreeNotifier::KEY => app(IsFreeNotifier::class),
            StudentClassNotifier::KEY => app(StudentClassNotifier::class),
            DiscountNotifier::KEY => app(DiscountNotifier::class),
            ConversationPackageNotifier::KEY => app(ConversationPackageNotifier::class),
            HolidaysNotifier::KEY => app(HolidaysNotifier::class),
            CoachingWeeksNotifier::KEY => app(CoachingWeeksNotifier::class),

            //section
            InstructorNotifier::KEY => app(InstructorNotifier::class),
            SectionCreatedNotifier::KEY => app(SectionCreatedNotifier::class),

            //enrollment
            SectionChangedNotifier::KEY => app(SectionChangedNotifier::class),
            CourseChangedNotifier::KEY => app(CourseChangedNotifier::class),


            default => throw new \InvalidArgumentException(sprintf('Notifier not found')),
        };
    }
}
