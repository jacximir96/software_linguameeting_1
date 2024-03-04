<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Form;

use App\Src\ConversationPackageDomain\Package\Presenter\Api\AvailabilitySetupPresenter;
use App\Src\ConversationPackageDomain\Package\Presenter\Api\AvailabilitySetupResponse;
use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\ConversationPackageDomain\SessionType\Repository\SessionTypeRepository;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Model\SessionSetup;
use App\Src\Localization\Language\Model\Language;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class CourseInformationFromCourseForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private SessionTypeRepository $sessionTypeRepository;

    private AvailabilitySetupPresenter $availabilitySetupPresenter;

    private AvailabilitySetupResponse $availabilitySetupResponse;

    private LinguaMoney $linguaMoney;

    private Course $course;

    private User $user;

    private array $booleanOptions = [];

    private array $languageOptions = [];

    private array $guideOptions = [];

    private array $makeUpSessions = [];

    public function __construct(
        FieldFormBuilder $fieldFormBuilder,
        SessionTypeRepository $sessionTypeRepository,
        AvailabilitySetupPresenter $availabilitySetupPresenter,
        LinguaMoney $linguaMoney,
    ) {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->sessionTypeRepository = $sessionTypeRepository;
        $this->availabilitySetupPresenter = $availabilitySetupPresenter;
        $this->linguaMoney = $linguaMoney;
    }

    public function availabilitySetup(): AvailabilitySetupResponse
    {
        return $this->availabilitySetupResponse;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function optionsCustomNumberSessions(): array
    {
        return $this->fieldFormBuilder->obtainNumberOptions(1, 12, 'desc');
    }

    public function smallGroupId(): int
    {
        return SessionType::SMALL_GROUPS;
    }

    public function oneOnOneId(): int
    {
        return SessionType::ONE_ON_ONE_ID;
    }

    public function dataAttributesLingroLanguage(): array
    {
        return $this->fieldFormBuilder->obtainDataAttributesLingroLanguage();
    }

    public function showLingroUserField(): bool
    {
        if (empty(old())) {
            return $this->course->language->isLingro();
        }

        $requestHasLanguageField = ! is_null(old('language_id'));

        if ($requestHasLanguageField) {
            return true;
        }

        return false;
    }

    public function showGuideField(): bool
    {
        if (empty(old())) {
            return $this->course->isLingro();
        }

        $requestHasLingroUserField = ! is_null(old('user_lingro'));

        if ($requestHasLingroUserField) {
            return true;
        }

        return false;
    }

    public function isSessionsNumberSelected(int $numberOfSessionsToEvaluate): bool
    {
        if (empty(old())) {
            return $this->course->conversationPackage->isEqualNumberOfSession($numberOfSessionsToEvaluate);
        }

        if ($this->isSessionsDropdownSelected()) {
            return false;
        }

        if (! is_numeric(old('number_session'))) {
            return false;
        }

        $numberOfSessionsSelected = (int) old('number_session');

        return $numberOfSessionsSelected == $numberOfSessionsToEvaluate;
    }

    public function isSessionsDropdownSelected(): bool
    {
        if (empty(old())) {
            return $this->course->conversationPackage->isCustomNumberOfSession();
        }

        return is_numeric(old('sessions_dropdown'));
    }

    public function isSessionsDurationSelected(int $durationOfSessionToEvaluate): bool
    {
        if (empty(old())) {
            return $this->course->conversationPackage->isEqualDurationOfSession($durationOfSessionToEvaluate);
        }

        $hasDurationSessionSelected = is_numeric(old('duration_session'));

        if (! $hasDurationSessionSelected) {
            return false;
        }

        $durationOfSessionSelected = (int) old('duration_session');

        return $durationOfSessionSelected == $durationOfSessionToEvaluate;
    }

    public function isSessionsDurationDisabled(int $durationOfSessionToEvaluate): bool
    {
        if (empty(old())) {
            $sessionType = $this->course->conversationPackage->sessionType;
            $sessionSetup = SessionSetup::createWithInteger($this->course->conversationPackage->number_session, $durationOfSessionToEvaluate);
        } else {
            $sessionTypeId = old('session_type_id');
            if (! is_numeric($sessionTypeId)) {
                return false;
            }

            if (is_null(old('number_session')) or ! is_numeric(old('number_session'))) {
                return false;
            }

            $sessionType = SessionType::find($sessionTypeId);
            $numSessions = old('number_session');

            $sessionSetup = SessionSetup::createWithInteger($numSessions, $durationOfSessionToEvaluate);
        }

        if ($this->availabilitySetup()->isSessionSetupAvailability($sessionType, $sessionSetup)) {
            return false;
        }

        return true;
    }

    public function backStepRoute(): string
    {
        return route('get.admin.course.coaching_form.create.update.academic_dates', $this->course);
    }

    public function allowsFullEdition(): bool
    {
        return $this->course->allowsFullEdition($this->user);
    }

    public function config(Course $course, User $user)
    {
        $this->initialize($course, $user);

        $this->configModel($course);

        $this->configOptionsDropdown();

        $this->configThatDependsFromSessionType($course);

        $this->configGuidesOptions();
    }

    private function initialize(Course $course, User $user)
    {
        $this->isEdit = true;

        $this->course = $course;

        $this->user = $user;

        $this->action = route('post.admin.course.coaching_form.update.course_information', $course);
    }

    private function configModel(Course $course)
    {
        $this->model = $course->toArray();

        $this->model['number_session'] = $course->conversationPackage->number_session;
        $this->model['duration_session'] = $course->conversationPackage->duration_session;
        $this->model['student_class'] = $course->student_class;
        $this->model['only_week_makeups'] = $course->only_week_makeups;

        if (empty(old())) {
            if ($this->course->conversationPackage->isCustomNumberOfSession()) {
                $this->model['sessions_dropdown'] = $this->course->conversationPackage->number_session;
            }
        }

        $this->model['user_lingro'] = (bool) $course->is_lingro;

        if ($course->isLingro()) {
            $this->model['guide_id'] = $course->conversation_guide_id;
        }

        if ($course->hasDiscount()) {
            $this->model['discount'] = $this->linguaMoney->formatForFormField($course->discount);
        }
    }

    private function configOptionsDropdown()
    {
        $this->booleanOptions = $this->fieldFormBuilder->obtainBooleanOptions();

        $this->languageOptions = $this->fieldFormBuilder->obtainLanguageOptions();

        $this->makeUpSessions = $this->fieldFormBuilder->obtainMakeUpsPurchase();
    }

    private function configThatDependsFromSessionType(Course $course)
    {
        $sessionType = $course->conversationPackage->sessionType;

        $this->availabilitySetupResponse = $this->availabilitySetupPresenter->handle();

        $this->model['session_type_id'] = $sessionType->id;
    }

    private function configGuidesOptions()
    {
        $haveToLoadTheLingroGuides = $this->haveToLoadTheLingroGuides();

        if ($haveToLoadTheLingroGuides) {

            $language = Language::find($this->languageId());

            if ($this->course->isLingro() and $this->course->language->isSpanish()) {
                $this->guideOptions = $this->fieldFormBuilder->obtainSpanishLingroGuide();
            } else {
                $this->guideOptions = $this->fieldFormBuilder->obtainLingroGuide($language);
            }
        }
    }

    private function haveToLoadTheLingroGuides(): bool
    {
        if (old()) {
            $languageIsSelected = ! is_null(old('language_id'));
            $isUserLingro = old('user_lingro') == '1';

            return $languageIsSelected and $isUserLingro;
        }

        return $this->course->isLingro();
    }

    private function languageId(): int
    {
        if (old('language_id')) {
            return old('language_id');
        }

        return $this->course->language_id;
    }
}
