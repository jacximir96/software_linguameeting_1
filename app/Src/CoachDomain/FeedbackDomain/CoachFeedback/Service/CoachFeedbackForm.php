<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service;

use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use App\Src\CoachDomain\FeedbackDomain\FeedbackType\Model\FeedbackType;
use App\Src\Localization\Language\Model\Language;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class CoachFeedbackForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $languageOptions;

    private Collection $feedbackSortedByTypes;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;

        $this->feedbackSortedByTypes = collect();
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function observationsOptions(int $typeId, int $subtypeId, Language $language)
    {
        return $this->fieldFormBuilder->obtainFeedbackObservationsOptions($typeId, $subtypeId, $language);
    }

    public function suggestionsOptions(int $typeId, int $subtypeId, Language $language)
    {
        return $this->fieldFormBuilder->obtainFeedbackSuggestionsOptions($typeId, $subtypeId, $language);
    }

    public function feedbackSortedByTypes(): Collection
    {
        return $this->feedbackSortedByTypes;
    }

    public function configForCreate(User $coach)
    {

        $this->action = route('post.admin.coach.coach_feedback.create', $coach->hashId());

        $this->model = [];

        $this->configOptions();

        $this->configFeedbackSortedByTypesEmpty();
    }

    public function configForEdit(CoachFeedback $coachFeedback)
    {

        $this->isEdit = true;

        $this->action = route('post.admin.coach.coach_feedback.update', $coachFeedback->hashId());

        $this->configModel($coachFeedback);

        $this->configOptions();

        $this->configFeedbackSortedByTypes($coachFeedback);
    }

    private function configModel(CoachFeedback $coachFeedback)
    {

        $this->model = $coachFeedback->toArray();
        $this->model['observations_text'] = $coachFeedback->observations;

        $wrapper = new CoachFeedbackWrapper($coachFeedback);

        $observations = [];
        $suggestions = [];
        $alternativesText = [];

        foreach ($wrapper->feedbackSortedByTypes() as $typeWrapper) {

            foreach ($typeWrapper->subtypes() as $subtypeWrapper) {
                $observations[$typeWrapper->id()][$subtypeWrapper->id()] = $subtypeWrapper->observationId();
                $suggestions[$typeWrapper->id()][$subtypeWrapper->id()] = $subtypeWrapper->suggestionId();
                $alternativesText[$typeWrapper->id()][$subtypeWrapper->id()] = $subtypeWrapper->alternativeText();
            }
        }

        $this->model['observations'] = $observations;
        $this->model['suggestions'] = $suggestions;
        $this->model['alternatives_text'] = $alternativesText;
    }

    private function configOptions()
    {

        $languageIdFeedbacks = [Language::ENGLISH_ID, Language::SPANISH_ID];
        $this->languageOptions = $this->fieldFormBuilder->obtainLanguagesOptions($languageIdFeedbacks);
    }

    private function configFeedbackSortedByTypes(CoachFeedback $coachFeedback)
    {

        $feedbacks = collect();

        foreach ($coachFeedback->feedbacks as $feedback) {

            $wrapper = new FeedbackTypeWrapper($feedback);

            $feedbacks->put($wrapper->id(), $wrapper);

        }

        $this->feedbackSortedByTypes = $feedbacks;
    }

    private function configFeedbackSortedByTypesEmpty()
    {

        $typesModels = FeedbackType::with('subtype')->get()->sortKeys();

        $feedbacks = collect();

        foreach ($typesModels as $typeModel) {

            $subtypesModels = $typeModel->subtype->sortKeys();

            $subtypes = [];
            foreach ($subtypesModels as $subtypeModel) {
                $subtypeData = ['id_sub_feed' => $subtypeModel->id, 'suggestion' => 0, 'observation' => 0, 'alternative_text' => 0];
                $subtypes[$subtypeModel->id] = $subtypeData;
            }

            $typeData = ['id_feed' => $typeModel->id, 'subtypes' => $subtypes];

            $wrapper = new FeedbackTypeWrapper($typeData);
            $feedbacks->put($wrapper->id(), $wrapper);
        }

        $this->feedbackSortedByTypes = $feedbacks;
    }
}
