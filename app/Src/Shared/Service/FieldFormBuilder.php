<?php

namespace App\Src\Shared\Service;

use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\CoachDomain\CoachHelp\Model\CoachHelpType;
use App\Src\CoachDomain\FeedbackDomain\FeedbackObservation\Model\FeedbackObservation;
use App\Src\CoachDomain\FeedbackDomain\FeedbackSuggestion\Model\FeedbackSuggestion;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\ReviewOption\Model\ReviewOption;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Model\DiscountType;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;
use App\Src\CoachDomain\SalaryDomain\SalaryType\Model\SalaryType;
use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\Guide\Repository\GuideRepository;
use App\Src\ConversationGuideDomain\GuideOrigin\Model\GuideOrigin;
use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\ServiceType\Model\ServiceType;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\ParticipationType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PreparedClassType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PunctualityType;
use App\Src\ExperienceDomain\CodeOfferType\Model\CodeOfferType;
use App\Src\ExperienceDomain\ExperienceType\Model\ExperienceType;
use App\Src\HelpDomain\IssueType\Model\IssueType;
use App\Src\InstructorDomain\Instructor\Repository\InstructorRepository;
use App\Src\InstructorDomain\InstructorHelp\Model\InstructorHelpType;
use App\Src\Localization\Country\Model\Country;
use App\Src\Localization\Language\Model\Language;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\NotificationDomain\NotificationLevel\Model\NotificationLevel;
use App\Src\NotificationDomain\NotificationType\Model\NotificationType;
use App\Src\PaymentDomain\AccountType\Model\AccountType;
use App\Src\PaymentDomain\Currency\Model\Currency;
use App\Src\PaymentDomain\MethodPayment\Model\MethodPayment;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\StudentDomain\AccommodationType\Model\AccommodationType;
use App\Src\StudentDomain\StudentHelp\Model\StudentHelpType;
use App\Src\TimeDomain\Semester\Model\Semester;
use App\Src\TimeDomain\Time\Model\Time;
use App\Src\TimeDomain\TimeHour\Service\BuilderTimes;
use App\Src\UniversityDomain\Level\Model\Level;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class FieldFormBuilder
{
    public function obtainConversationGuideChapters(ConversationGuide $conversationGuide): array
    {
        return Chapter::where('conversation_guide_id', $conversationGuide->id)
            ->get()
            ->sortBy(function ($chapter) {
                return $chapter->name;
            }, SORT_NATURAL | SORT_FLAG_CASE)
            ->pluck('name', 'id')
            ->toArray();
    }

    public function obtainCountryOptions(): array
    {
        return Country::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainCourseTypeOptionsWithIsbnAndPrice(): array
    {
        return ConversationPackage::where('experiences', 0)
            ->orderBy('name')
            ->get()
            ->pluck('description_with_isbn', 'id')
            ->toArray();
    }

    public function obtainExperiencesOptions(): array
    {
        return [
            0 => 'Optional',
            1 => 'For credit',
        ];
    }

    public function obtainExperiencesCourseTypeOptionsWithIsbnAndPrice(): array
    {
        return ConversationPackage::where('experiences', 1)
            ->orderBy('name')
            ->get()
            ->pluck('description_with_isbn', 'id')
            ->toArray();
    }

    public function obtainInstructorsOptionsByUniversity(University $university): array
    {
        $criteria = new CriteriaSearch(['university_id' => $university->id]);
        $criteria->withoutPaginate();

        $repository = app(InstructorRepository::class);
        $instructors = $repository->search($criteria);

        return $instructors->pluck('full_name', 'id')->toArray();
    }

    public function obtainInstructorsOptionsByUniversityAndRole(University $university, Collection $roles): array
    {
        $criteria = new CriteriaSearch([
            'university_id' => $university->id,
            'role_id' => $roles,
            'active' => 1,
        ]);
        $criteria->withoutPaginate();

        $repository = app(InstructorRepository::class);
        $instructors = $repository->search($criteria);

        return $instructors->pluck('full_name', 'id')->toArray();
    }

    public function obtainCoachesOptions(): array
    {
        $repository = app(CoachRepository::class);
        $coaches = $repository->all();

        $options = [];

        foreach ($coaches as $coach) {
            $options[$coach->id] = $coach->writeFullName();
        }

        return $options;
    }

    public function obtainCoordinatorsOptionsByUniversity(University $university): array
    {
        $criteria = new CriteriaSearch([
            'university_id' => $university->id,
            'role_id' => config('linguameeting.user.roles.instructor_coordinator'),
        ]);
        $criteria->withoutPaginate();

        $repository = app(InstructorRepository::class);
        $instructors = $repository->search($criteria);

        return $instructors->pluck('full_name', 'id')->toArray();
    }

    public function obtainCoachesOptionsToBeCoordinated(): array
    {
        $repository = app(CoachRepository::class);
        $coaches = $repository->obtainCoachesWithoutCoordinator();

        $options = [];

        foreach ($coaches as $coach) {
            $options[$coach->id] = $coach->writeFullName();
        }

        return $options;
    }

    public function obtainCoachesCoordinatorsOptions(): array
    {
        $repository = app(CoachRepository::class);
        $coaches = $repository->obtainCoachesCoordinators();

        $options = [];

        foreach ($coaches as $coach) {
            $options[$coach->id] = $coach->writeFullName();
        }

        return $options;
    }

    public function obtainCoachHelpTypeOptions(): array
    {
        return CoachHelpType::orderBy('id')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainStudentHelpTypeOptions(): array
    {
        return StudentHelpType::orderBy('id')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainInstructorHelpTypeOptions(): array
    {
        return InstructorHelpType::orderBy('id')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainCoachesOptionsToBeAssignToCourse(Course $course): array
    {
        $repository = app(CoachRepository::class);
        $coaches = $repository->obtainCoachesForAssignToCourse($course);

        $options = [];

        foreach ($coaches as $coach) {
            $options[$coach->id] = $coach->writeFullName();
        }

        return $options;
    }

    public function obtainLingroGuide(Language $language): array
    {
        return ConversationGuide::query()
            ->where('guide_origin_id', GuideOrigin::LINGROLEARNING_ID)
            ->where('language_id', $language->id)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    public function obtainSpanishLingroGuide(): array
    {
        $repo = app(GuideRepository::class);

        return $repo->obtainSpanishLingroWithSpecificOrder()
            ->pluck('name', 'id')
            ->toArray();
    }

    public function obtainLanguageOptions(string $orderBy = 'id'): array
    {
        return Language::all()->sortByDesc(function ($language) {
            return $language->weightForOrder();
        })->pluck('name', 'id')->toArray();
    }

    public function obtainLanguagesOptions(array $languageIds, string $orderBy = 'id'): array
    {
        return Language::whereIn('id', $languageIds)->get()->sortByDesc(function ($language) {
            return $language->weightForOrder();
        })->pluck('name', 'id')->toArray();
    }

    public function obtainOneLanguageOption(int $languageId): array
    {
        return Language::where('id', $languageId)->get()->pluck('name', 'id')->toArray();
    }

    public function obtainDataAttributesLingroLanguage(string $orderBy = 'id'): array
    {
        $languages = Language::all()->sortBy(function ($language) {
            return $language->weightForOrder();
        });

        return collect($languages)
            ->mapWithKeys(function ($language) {
                return [$language->id => ['data-is-lingro' => $language->isLingro() ? 1 : 0]];
            })->all();
    }

    public function obtainMakeUpsPurchase(): array
    {
        return [
            0 => 'None',
            1 => 'Add 1 make-up session',
            2 => 'Add 2 make-up sessions',
            3 => 'Add 3 make-up sessions',
            10 => 'Add unlimited make-up sessions',
        ];
    }

    public function obtainStatusOptions(): array
    {
        return [1 => 'Active', 2 => 'Disabled'];
    }

    public function obtainStatusUserOptions(): array
    {
        return [1 => 'Active', 2 => 'Disabled', 3 => 'Blocked', 4 => 'Deleted'];
    }

    public function obtainStatusUniversityOptions(): array
    {
        return [
            config('lingua_status.university.active') => 'Active',
            config('lingua_status.university.disable') => 'Deactivated',
            config('lingua_status.university.removed') => 'Deleted',
        ];
    }

    public function obtainStatusActiveOptions(): array
    {
        return ['1' => 'Active', 2 => 'Deactivated'];
    }

    public function obtainStatusCourseOptions(): array
    {
        return ['active' => 'Active', 'draft' => 'Draft', 'past' => 'Past'];
    }

    public function obtainSemesterOptions(): array
    {
        return Semester::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainTimezonesOptions(string $fieldToView = 'name'): array
    {
        return TimeZone::orderBy($fieldToView)->get()->pluck($fieldToView, 'id')->toArray();
    }

    public function obtainTimeOptions(): array
    {
        return Time::orderBy('id')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainUniversityOptions(): array
    {
        return University::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainUniversityInstructorOptions(User $instructor): array
    {

        $universities = $instructor->university;

        $universitiesIds = $universities->pluck('id', 'id')->toArray();

        return University::whereIn('id', $universitiesIds)->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainCourseOptions(): array
    {
        return Course::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainCourseOptionsFromUniversities(array $universitesIds, string $orderField = 'name', string $orderDirection = 'DESC'): array
    {
        return Course::query()
            ->orderBy($orderField, $orderDirection)
            ->whereIn('university_id', $universitesIds)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    public function obtainUniversityWithCodeOptions(): array
    {
        return University::has('bookstoreRequest')->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainUniversityLevelOptions(): array
    {
        return Level::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainCoachLevelOptions(): array
    {
        return \App\Src\CoachDomain\Level\Model\Level::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainCurrencyOptions(): array
    {
        return Currency::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainAccountTypeOptions(): array
    {
        return AccountType::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainSessionStatusOptions(): array
    {
        return SessionStatus::orderBy('id')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainMethodPaymentsOptions(): array
    {
        return MethodPayment::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainPuntualityTypeOptions(string $field): array
    {
        return PunctualityType::orderBy('id')->get()->pluck($field, 'id')->toArray();
    }

    public function obtainPreparedClassOptions(string $field): array
    {
        return PreparedClassType::orderBy('id')->get()->pluck($field, 'id')->toArray();
    }

    public function obtainParticipationTypeOptions(string $field): array
    {
        return ParticipationType::orderBy('id')->get()->pluck($field, 'id')->toArray();
    }

    public function obtainCodeOfferExperienceOptions(): array
    {
        return CodeOfferType::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainServiceTypeOptions(): array
    {
        return ServiceType::orderBy('id')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainExperiencesTypeOptions(bool $withPrice = true): array
    {

        if (! $withPrice) {
            return ExperienceType::orderBy('id')->get()->pluck('name', 'id')->toArray();
        }

        $linguaMoney = new LinguaMoney();
        $types = ExperienceType::orderBy('id')->get();

        $options = [];
        foreach ($types as $type) {
            $price = $linguaMoney->format($type->price);

            if ($type->isUnlimited()) {
                $options[$type->id] = $type->name.' ('.$price.')';
            } else {
                $options[$type->id] = $type->num_experiences.' Experience'.(($type->num_experiences == 1) ? '' : 's').' ('.$price.')';
            }
        }

        return $options;
    }

    public function obtainFeedbackObservationsOptions(int $typeId, int $subtypeId, Language $language): array
    {

        $languageField = $language->isSpanish() ? 'es_title' : 'eng_title';

        return FeedbackObservation::query()
            ->where('type_id', $typeId)
            ->where('subtype_id', $subtypeId)
            ->orderBy('id')
            ->get()
            ->pluck($languageField, 'id')
            ->toArray();
    }

    public function obtainFeedbackSuggestionsOptions(int $typeId, int $subtypeId, Language $language): array
    {

        $languageField = $language->isSpanish() ? 'es_title' : 'eng_title';

        return FeedbackSuggestion::query()
            ->where('type_id', $typeId)
            ->where('subtype_id', $subtypeId)
            ->orderBy('id')
            ->get()
            ->pluck($languageField, 'id')
            ->toArray();
    }

    public function obtainNotificationLevels(): array
    {
        return NotificationLevel::orderBy('id')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainNotificationTypes(): array
    {
        return NotificationType::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainNotificationTypesFromLevelIds(array $levelsIds): array
    {
        return NotificationType::whereIn('notification_level_id', $levelsIds)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    public function obtainSalaryTypeOptions(): array
    {
        return SalaryType::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainDiscountTypeOptions(): array
    {
        return DiscountType::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainIncentiveTypeOptions(): array
    {
        return IncentiveType::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainReviewOptionOptions(): array
    {
        return ReviewOption::query()->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainAvailabilitySlotsTime(int $interval): array
    {

        $builder = new BuilderTimes();

        $slots = $builder->buildSlotsByInterval($interval);

        return $slots->toArray();
    }

    public function obtainAccommodationTypeOptions(): array
    {
        return AccommodationType::orderBy('description')->get()->pluck('description', 'id')->toArray();
    }

    public function obtainNumberOptions(int $from, int $to, string $order = 'asc'): array
    {
        $values = array_combine(range($from, $to), range($from, $to));

        if ($order == 'asc') {
            asort($values);
        } else {
            arsort($values);
        }

        return $values;
    }

    public function obtainBooleanOptions(string $order = 'desc'): array
    {
        if ($order == 'asc') {
            return [0 => 'No', 1 => 'Yes'];
        }

        return [1 => 'Yes', 0 => 'No'];
    }

    public function obtainInstructorRoleOptions(): array
    {
        $roles = \Spatie\Permission\Models\Role::query()->whereIn('id', config('linguameeting.user.roles.instructor'))->get()->pluck('name', 'id');

        //ordenar por un orden específico
        $order = config('linguameeting.user.roles.instructor_order');
        $roles = $roles->sortBy(function ($value, $key) use ($order) {
            return array_search($key, $order);
        });

        return $roles->toArray();
    }

    public function obtainCoachRoleOptions(): array
    {
        $roles = \Spatie\Permission\Models\Role::query()->whereIn('id', config('linguameeting.user.roles.coach'))->get()->pluck('name', 'id');

        return $roles->toArray();
    }

    public function obtainIssueTypeOptions(): array
    {
        return IssueType::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainSessionTypeOptions(): array
    {
        return SessionType::orderBy('id')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainExperienceLevelOptions(): array
    {
        return \App\Src\ExperienceDomain\Level\Model\Level::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function obtainSpecificDatesOptions(): array
    {

        return [
            config('linguameeting.list.search_specific_dates.today.key') => config('linguameeting.list.search_specific_dates.today.name'),
            config('linguameeting.list.search_specific_dates.yesterday.key') => config('linguameeting.list.search_specific_dates.yesterday.name'),
            config('linguameeting.list.search_specific_dates.current_week.key') => config('linguameeting.list.search_specific_dates.current_week.name'),
            config('linguameeting.list.search_specific_dates.last_week.key') => config('linguameeting.list.search_specific_dates.last_week.name'),
            config('linguameeting.list.search_specific_dates.current_month.key') => config('linguameeting.list.search_specific_dates.current_month.name'),
            config('linguameeting.list.search_specific_dates.last_month.key') => config('linguameeting.list.search_specific_dates.last_month.name'),
            config('linguameeting.list.search_specific_dates.current_year.key') => config('linguameeting.list.search_specific_dates.current_year.name'),
            config('linguameeting.list.search_specific_dates.last_year.key') => config('linguameeting.list.search_specific_dates.last_year.name'),
        ];
    }

    public function notificationReadStatusOptions(): array
    {

        return [
            config('linguameeting.notification.read_status.all.key') => config('linguameeting.notification.read_status.all.name'),
            config('linguameeting.notification.read_status.yes.key') => config('linguameeting.notification.read_status.yes.name'),
            config('linguameeting.notification.read_status.no.key') => config('linguameeting.notification.read_status.no.name'),
        ];
    }

    public function obtainMonthsOptions(): array
    {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
    }

    public function obtainShortMonthsOptions(): array
    {
        return [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        ];
    }
}
