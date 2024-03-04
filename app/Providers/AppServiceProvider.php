<?php

namespace App\Providers;


use App\Src\CoachDomain\BillingInfo\Model\BillingInfo;
use App\Src\CoachDomain\CoachHelp\Model\CoachHelp;
use App\Src\CoachDomain\CoachHelp\Model\CoachHelpType;
use App\Src\CoachDomain\CoachInfo\Model\CoachInfo;
use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\CoachDomain\InvoiceDomain\InvoiceDetail\Model\InvoiceDetail;
use App\Src\CoachDomain\SemesterFinished\Model\SemesterFinished;
use App\Src\CoachDomain\FeedbackDomain\InstructorEvaluation\Model\InstructorEvaluation;
use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluation\Model\ManagerEvaluation;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use App\Src\CoachDomain\FeedbackDomain\FeedbackObservation\Model\FeedbackObservation;
use App\Src\CoachDomain\FeedbackDomain\FeedbackSubtype\Model\FeedbackSubtype;
use App\Src\CoachDomain\FeedbackDomain\FeedbackSuggestion\Model\FeedbackSuggestion;
use App\Src\CoachDomain\FeedbackDomain\FeedbackType\Model\FeedbackType;
use App\Src\CoachDomain\Occupation\Model\Occupation;
use App\Src\CoachDomain\Payment\Model\Payment;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\ReviewOption\Model\ReviewOption;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Model\CoachReview;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Model\CoachReviewOption;
use App\Src\CoachDomain\SalaryDomain\Discount\Model\Discount;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Model\DiscountType;
use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;
use App\Src\CoachDomain\SalaryDomain\IncentiveFrequency\Model\IncentiveFrequency;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;
use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use App\Src\CoachDomain\SalaryDomain\SalaryType\Model\SalaryType;
use App\Src\CoachDomain\Substitution\Model\Substitution;
use App\Src\Config\Model\Config;
use App\Src\ConversationGuideDomain\Template\Model\Template;
use App\Src\ConversationGuideDomain\TemplateFile\Model\TemplateFile;
use App\Src\CourseDomain\ServiceType\Model\ServiceType;
use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;
use App\Src\CourseDomain\CourseCoach\Model\CourseCoach;
use App\Src\CourseDomain\CourseCoordinator\Model\CourseCoordinator;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\AssignmentChapter\Model\AssignmentChapter;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Holiday\Model\Holiday;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\CourseDomain\SectionTeachingAssistant\Model\SectionTeachingAssistant;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\ReplacedCoach\Model\ReplacedCoach;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\ParticipationType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PreparedClassType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PunctualityType;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus;
use App\Src\EmailDomain\Email\Model\Email;
use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluationFile\Model\ManagerEvaluationFile;
use App\Src\ConversationGuideDomain\ChapterFile\Model\GuideChapterFile;
use App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile;
use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\GuideOrigin\Model\GuideOrigin;
use App\Src\EmailDomain\EmailSession\Model\EmailSession;
use App\Src\ExperienceDomain\CodeOfferType\Model\CodeOfferType;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceComment\Model\ExperienceComment;
use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFile;
use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFileType;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Model\ExperienceRegisterPublic;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\File\BookstoreRequestFile\Model\BookstoreRequestFile;
use App\Src\HelpDomain\Issue\Model\Issue;
use App\Src\HelpDomain\IssueFile\Model\IssueFile;
use App\Src\HelpDomain\IssueType\Model\IssueType;
use App\Src\InstructorDomain\CoordinatorRequest\Model\CoordinatorRequest;
use App\Src\InstructorDomain\InstructorHelp\Model\InstructorHelp;
use App\Src\InstructorDomain\InstructorHelp\Model\InstructorHelpType;
use App\Src\InstructorDomain\TeachingAssistant\Model\TeachingAssistant;
use App\Src\Localization\Country\Model\Country;
use App\Src\Localization\Language\Model\Language;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\MessagingDomain\File\Model\MessageFile;
use App\Src\MessagingDomain\Message\Model\Message;
use App\Src\MessagingDomain\Participant\Model\Participant;
use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\MessagingDomain\ThreadRead\Model\ThreadRead;
use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\NotificationDomain\NotificationLevel\Model\NotificationLevel;
use App\Src\NotificationDomain\NotificationRecipient\Model\NotificationRecipient;
use App\Src\NotificationDomain\NotificationType\Model\NotificationType;
use App\Src\PaymentDomain\AccountType\Model\AccountType;
use App\Src\PaymentDomain\Currency\Model\Currency;
use App\Src\PaymentDomain\MethodPayment\Model\MethodPayment;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail;
use App\Src\RegisterCodeDomain\BookstoreRequestFileType\Model\BookstoreRequestFileType;
use App\Src\StudentDomain\Accommodation\Model\Accommodation;
use App\Src\StudentDomain\AccommodationType\Model\AccommodationType;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\EnrollmentStatus\Model\EnrollmentStatus;
use App\Src\StudentDomain\EnrollmentSurvey\Model\EnrollmentSurvey;
use App\Src\StudentDomain\ExtraSession\Model\ExtraSession;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use App\Src\StudentDomain\MakeupType\Model\MakeupType;
use App\Src\PaymentDomain\PaymentRefund\Model\PaymentRefund;
use App\Src\StudentDomain\StudentHelp\Model\StudentHelp;
use App\Src\StudentDomain\StudentHelp\Model\StudentHelpType;
use App\Src\Survey\Model\Survey;
use App\Src\ThirdPartiesDomain\Lingro\Model\LingroRegister;
use App\Src\TimeDomain\Semester\Model\Semester;
use App\Src\TimeDomain\Time\Model\Time;
use App\Src\TimeDomain\TimeHour\Model\TimeHour;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\UniversityDomain\Instructor\Model\UniversityInstructor;
use App\Src\UniversityDomain\Level\Model\Level;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\Hobby\Model\Hobby;
use App\Src\UserDomain\Language\Model\UserLanguage;
use App\Src\UserDomain\ProfileImage\Model\ProfileImage;
use App\Src\UserDomain\User\Model\User;
use App\Src\ZoomDomain\ZoomMeeting\Model\ZoomMeeting;
use App\Src\ZoomDomain\ZoomRecording\Model\ZoomRecording;
use App\Src\ZoomDomain\ZoomUser\Model\ZoomUser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LinguaMoney::class, function (Application $app) {
            return new LinguaMoney();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        Relation::enforceMorphMap([
            'accommodation' => Accommodation::class,
            'accommodation_type' => AccommodationType::class,
            'account_type' => AccountType::class,
            'assignment_chapter' => AssignmentChapter::class,
            'assignment_file' => AssignmentFile::class,
            //'bookstore_code' => RegisterCode::class,
            'bookstore_request' => BookstoreRequest::class,
            'bookstore_request_file' => BookstoreRequestFile::class,
            'bookstore_request_file_type' => BookstoreRequestFileType::class,
            'coach_billing_info' => BillingInfo::class,
            'coach_coordinator' => CourseCoordinator::class,
            'coach_instructor_evaluation' => InstructorEvaluation::class,
            'coach_feedback' => CoachFeedback::class,
            'coach_help' => CoachHelp::class,
            'coach_help_type' => CoachHelpType::class,
            'coach_info' => CoachInfo::class,
            'coach_invoice' => Invoice::class,
            'coach_invoice_detail' => InvoiceDetail::class,
            'coach_level' => \App\Src\CoachDomain\Level\Model\Level::class,
            'coach_occupation' => Occupation::class,
            'coach_payment' => Payment::class,
            'coach_review' => CoachReview::class,
            'coach_review_option' => CoachReviewOption::class,
            'coach_semester_finished' => SemesterFinished::class,
            'coach_schedule' => CoachSchedule::class,
            'coach_substitution' => Substitution::class,
            'code_offer_type' => CodeOfferType::class,
            'config' => Config::class,
            'conversation_guide' => ConversationGuide::class,
            'conversation_guide_file' => ConversationGuideFile::class,
            'coordinator_request' => CoordinatorRequest::class,
            'country' => Country::class,
            Course::MORPH => Course::class,
            'course_assignment' => Assignment::class,
            'course_coach' => CourseCoach::class,
            'course_coordinator' => \App\Src\CoachDomain\CoachCoordinator\Model\CoachCoordinator::class,
            'conversation_package' => ConversationPackage::class,
            'currency' => Currency::class,
            'coaching_week' => CoachingWeek::class,
            'email' => Email::class,
            'email_session' => EmailSession::class,
            Enrollment::MORPH => Enrollment::class,
            EnrollmentStatus::MORPH => EnrollmentStatus::class,
            'enrollment_session' => EnrollmentSession::class,
            'enrollment_survey' => EnrollmentSurvey::class,
            Experience::MORPH => Experience::class,
            'experience_comment' => ExperienceComment::class,
            'experience_file' => ExperienceFile::class,
            'experience_file_type' => ExperienceFileType::class,
            'experience_level' => \App\Src\ExperienceDomain\Level\Model\Level::class,
            'experience_register' => ExperienceRegister::class,
            'experience_register_public' => ExperienceRegisterPublic::class,
            'extra_session' => ExtraSession::class,
            'feedback_observation' => FeedbackObservation::class,
            'feedback_subtype' => FeedbackSubtype::class,
            'feedback_suggestion' => FeedbackSuggestion::class,
            'feedback_type' => FeedbackType::class,
            'guide_chapter' => Chapter::class,
            'guide_chapter_file' => GuideChapterFile::class,
            'guide_origin' => GuideOrigin::class,
            'hobby' => Hobby::class,
            'holiday' => Holiday::class,
            'instructor_help' => InstructorHelp::class,
            'instructor_help_type' => InstructorHelpType::class,
            'issue' => Issue::class,
            'issue_file' => IssueFile::class,
            'issue_type' => IssueType::class,
            'language' => Language::class,
            'level_university' => Level::class,
            'lingro_register' => LingroRegister::class,
            Makeup::MORPH => Makeup::class,
            'makeup_type' => MakeupType::class,
            'manager_evaluation' => ManagerEvaluation::class,
            'manager_evaluation_file' => ManagerEvaluationFile::class,
            'method_payment' => MethodPayment::class,
            'notification' => Notification::class,
            'notification_level' => NotificationLevel::class,
            'notification_type' => NotificationType::class,
            'notification_recipient' => NotificationRecipient::class,
            'participation_type' => ParticipationType::class,
            'payment' => \App\Src\PaymentDomain\Payment\Model\Payment::class,
            'payment_detail' => PaymentDetail::class,
            'payment_refund' => PaymentRefund::class,
            'prepared_class_type' => PreparedClassType::class,
            'profile_image' => ProfileImage::class,
            'puntuality_type' => PunctualityType::class,
            'register_code' => RegisterCode::class,
            'replaced_coach' => ReplacedCoach::class,
            'review_option' => ReviewOption::class,

            'salary' => Salary::class,
            'salary_discount' => Discount::class,
            'salary_discount_type' => DiscountType::class,
            'salary_incentive_frequency' => IncentiveFrequency::class,
            'salary_incentive' => Incentive::class,
            'salary_incentive_type' => IncentiveType::class,
            'salary_type' => SalaryType::class,
            Section::MORPH => Section::class,
            'section_teaching_assistant' => SectionTeachingAssistant::class,
            'semester' => Semester::class,
            'service_type' => ServiceType::class,
            'session' => Session::class,
            'student_help' => StudentHelp::class,
            'student_help_type' => StudentHelpType::class,

            'student_review' => StudentReview::class,
            'session_status' => SessionStatus::class,
            'session_type' => SessionType::class,
            'survey' => Survey::class,
            'teaching_assisant' => TeachingAssistant::class,
            'timezone' => TimeZone::class,
            'type_incentive' => SalaryType::class,
            'template' => Template::class,
            'template_file' => TemplateFile::class,
            'thread' => Thread::class,
            'thread_file' => MessageFile::class,
            'thread_message' => Message::class,
            'thread_participant' => Participant::class,
            'thread_read' => ThreadRead::class,
            'time' => Time::class,
            'time_hour' => TimeHour::class,
            University::MORPH => University::class,
            'university_instructor' => UniversityInstructor::class,
            'user' => User::class,
            'user_public' => \App\Src\UserDomain\UserPublic\Model\User::class,
            'user_language' => UserLanguage::class,
            'zoom_meeting' => ZoomMeeting::class,
            'zoom_recording' => ZoomRecording::class,
            'zoom_user' => ZoomUser::class,

        ]);
    }
}
