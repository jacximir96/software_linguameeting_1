<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Form;

use App\Src\ConversationPackageDomain\Package\Presenter\Api\AvailabilitySetupPresenter;
use App\Src\ConversationPackageDomain\Package\Presenter\Api\AvailabilitySetupResponse;
use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\ConversationPackageDomain\SessionType\Repository\SessionTypeRepository;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Wizard;
use App\Src\CourseDomain\Course\Model\SessionSetup;
use App\Src\Localization\Language\Model\Language;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class CourseInformationFromWizardForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private SessionTypeRepository $sessionTypeRepository;

    private AvailabilitySetupPresenter $availabilitySetupPresenter;

    private AvailabilitySetupResponse $availabilitySetupResponse;

    private array $booleanOptions = [];

    private array $languageOptions = [];

    private array $guideOptions = [];

    private array $makeUpSessions = [];

    public function __construct(FieldFormBuilder $fieldFormBuilder, SessionTypeRepository $sessionTypeRepository, AvailabilitySetupPresenter $availabilitySetupPresenter)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->sessionTypeRepository = $sessionTypeRepository;
        $this->availabilitySetupPresenter = $availabilitySetupPresenter;
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
        $requestHasLanguageField = ! is_null(old('language_id'));

        if ($requestHasLanguageField) {
            return true;
        }

        return false;
    }

    public function showGuideField(): bool
    {
        $requestHasLingroUserField = ! is_null(old('user_lingro'));

        if ($requestHasLingroUserField) {
            return true;
        }

        return false;
    }

    public function isSessionsNumberSelected(int $numberOfSessionsToEvaluate): bool
    {
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
        return is_numeric(old('sessions_dropdown'));
    }

    public function isSessionsDurationSelected(int $durationOfSessionToEvaluate): bool
    {
        $hasDurationSessionSelected = is_numeric(old('duration_session'));

        if (! $hasDurationSessionSelected) {
            return false;
        }

        $durationOfSessionSelected = (int) old('duration_session');

        return $durationOfSessionSelected == $durationOfSessionToEvaluate;
    }

    public function isSessionsDurationDisabled(int $durationOfSessionToEvaluate): bool
    {
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

        if ($this->availabilitySetup()->isSessionSetupAvailability($sessionType, $sessionSetup)) {
            return false;
        }

        return true;
    }

    public function backStepRoute(): string
    {
        return route('get.admin.course.coaching_form.create.academic_dates');
    }

    public function allowsFullEdition(): bool
    {
        return true;
    }

    public function config(Wizard $wizard)
    {
        $this->action = route('post.admin.course.coaching_form.create.course_information');

        $this->model = $wizard->get();

        $this->booleanOptions = $this->fieldFormBuilder->obtainBooleanOptions();

        $this->languageOptions = $this->fieldFormBuilder->obtainLanguageOptions();

        $this->makeUpSessions = $this->fieldFormBuilder->obtainMakeUpsPurchase();

        $this->configurationThatDependsFromSessionType($wizard);

        $this->configGuidesOptionsGuides();

        $this->configMakeUpSessions();
    }

    private function configurationThatDependsFromSessionType(Wizard $wizard)
    {
        if ($wizard->hasSessionTypeId()) {
            $sessionType = $this->sessionTypeRepository->find($wizard->sessionTypeId());
        } else {
            $sessionType = $this->sessionTypeRepository->obtainSmallGroup();
        }

        $this->availabilitySetupResponse = $this->availabilitySetupPresenter->handle();

        $this->model['session_type_id'] = $sessionType->id;
        $this->model['student_class'] = $sessionType->defaultStudentsBySession()->get();
    }

    private function configGuidesOptionsGuides()
    {
        $haveToLoadTheGuides = $this->haveToLoadTheGuides();

        if ($haveToLoadTheGuides) {
            $language = Language::find(old('language_id'));

            $this->guideOptions = $this->fieldFormBuilder->obtainLingroGuide($language);
        }
    }

    private function haveToLoadTheGuides(): bool
    {
        $languageIsSelected = ! is_null(old('language_id'));
        $isUserLingro = old('user_lingro') == '1';

        return $languageIsSelected and $isUserLingro;
    }

    private function configMakeUpSessions()
    {
        $this->model['number_makeups'] = 1;
    }
}
