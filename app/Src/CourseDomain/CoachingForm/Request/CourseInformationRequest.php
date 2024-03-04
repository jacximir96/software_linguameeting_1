<?php

namespace App\Src\CourseDomain\CoachingForm\Request;

use App\Src\ConversationPackageDomain\Package\Repository\ConversationPackageRepository;
use App\Src\CourseDomain\CoachingForm\Rule\ConversationPackageSeleccionableRule;
use App\Src\CourseDomain\CoachingForm\Rule\GuideRule;
use App\Src\CourseDomain\CoachingForm\Rule\LingroUserRule;
use App\Src\CourseDomain\CoachingForm\Rule\NumSessionsUpdatableRule;
use App\Src\CourseDomain\CoachingForm\Rule\SessionTypeUpdatableRule;
use Illuminate\Foundation\Http\FormRequest;

class CourseInformationRequest extends FormRequest
{
    private $experienceSelectedInPrevStep = false;

    public function setExperienceSelectedInPrevStep(bool $value)
    {
        $this->experienceSelectedInPrevStep = $value;
    }

    public function isExperienceSelectedInPrevStep(): bool
    {
        return $this->experienceSelectedInPrevStep;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isCreateCourse()) {
            return $this->rulesWhenItsCreation();
        }

        if ($this->course->allowsFullEdition(user())) {
            return $this->rulesFullEdition();
        }

        return $this->rulesLimitedEdition();
    }

    public function isCreateCourse(): bool
    {
        return is_null($this->course);
    }

    public function messages()
    {
        return [
            'name.required' => trans('common_form.required', ['field' => 'title']),
            'number_session.required' => trans('common_form.required', ['field' => 'number of sessions']),
            'duration.required' => trans('common_form.required', ['field' => 'duration of sessions']),
            'student_class.required' => trans('common_form.required', ['field' => 'student per session']),
        ];
    }

    private function rulesWhenItsCreation(): array
    {
        $conversationPackageIsSeleccionable = new ConversationPackageSeleccionableRule($this, new ConversationPackageRepository());

        return [
            'name' => 'required',
            'session_type_id' => [$conversationPackageIsSeleccionable],
            'language_id' => 'required',
            'number_session' => ['required'],
            'duration_session' => ['required'],
            'user_lingro' => [new LingroUserRule($this)],
            'guide_id' => [new GuideRule($this)],
        ];
    }

    private function rulesFullEdition(): array
    {
        $conversationPackageIsSeleccionable = new ConversationPackageSeleccionableRule($this, new ConversationPackageRepository());

        return [
            'name' => 'required',
            'number_session' => ['required', new NumSessionsUpdatableRule($this)],
            'duration_session' => ['required'],
            'session_type_id' => [new SessionTypeUpdatableRule($this), $conversationPackageIsSeleccionable],
            'student_class' => 'required|min:1',
            'language_id' => 'required',
            'user_lingro' => [new LingroUserRule($this)],
            'guide_id' => [new GuideRule($this)],
        ];
    }

    private function rulesLimitedEdition(): array
    {
        return [
            'name' => 'required',
            'language_id' => 'required',
            'user_lingro' => [new LingroUserRule($this)],
            'guide_id' => [new GuideRule($this)],
        ];
    }

    public function isUserLingro(): bool
    {
        if ($this->has('user_lingro')) {
            return (bool) $this->user_lingro;
        }

        return false;
    }

    public function isFree(): bool
    {
        return (bool) $this->is_free;
    }

    public function numberMakeups(): int
    {
        if (! $this->has('number_makeups')) {
            return 0;
        }

        return (int) $this->number_makeups;
    }
}
