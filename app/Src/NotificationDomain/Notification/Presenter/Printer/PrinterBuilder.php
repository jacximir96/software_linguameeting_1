<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer;

use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Course\CoachingWeeksPrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Course\ConversationGuidePrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Course\ConversationPackagePrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Course\CourseCreatedPrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Course\DatesNotifierPrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Course\DiscountPrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Course\FreePrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Course\HolidaysPrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Course\LanguagePrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Course\NamePrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Course\SemesterPrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Course\StudentClassPrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Enrollment\CourseChangedPrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Enrollment\SectionChangedPrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Section\InstructorPrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Section\SectionCreatedPrinter;
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
use App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment\SectionChangedNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Section\InstructorNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Section\SectionCreatedNotifier;


class PrinterBuilder
{

    public function build (Notification $notification){

        return match($notification->extra['key']){

            //course
            CourseCreatedNotifier::KEY => new CourseCreatedPrinter($notification->extra),
            CourseDatesNotifier::KEY => new DatesNotifierPrinter($notification->extra),
            SemesterNotifier::KEY => new SemesterPrinter($notification->extra),
            NameNotifier::KEY => new NamePrinter($notification->extra),
            LanguageNotifier::KEY => new LanguagePrinter($notification->extra),
            ConversationGuideNotifier::KEY => new ConversationGuidePrinter($notification->extra),
            IsFreeNotifier::KEY => new FreePrinter($notification->extra),
            StudentClassNotifier::KEY => new StudentClassPrinter($notification->extra),
            DiscountNotifier::KEY => new DiscountPrinter($notification->extra),
            ConversationPackageNotifier::KEY => new ConversationPackagePrinter($notification->extra),
            HolidaysNotifier::KEY => new HolidaysPrinter($notification->extra),
            CoachingWeeksNotifier::KEY => new CoachingWeeksPrinter($notification->extra),

            //section
            InstructorNotifier::KEY => new InstructorPrinter($notification->extra),
            SectionCreatedNotifier::KEY => new SectionCreatedPrinter($notification->extra),

            //enrollment
            SectionChangedNotifier::KEY => new SectionChangedPrinter($notification->extra),
            CourseChangedNotifier::KEY => new CourseChangedPrinter($notification->extra),

            default => null,

        };

    }
}
