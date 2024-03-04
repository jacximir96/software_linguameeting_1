<?php

namespace App\Src\NotificationDomain\Notification\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class SearchForm extends BaseSearchForm
{
    const KEY_FORM = 'notification_searcher';

    private FieldFormBuilder $fieldFormBuilder;

    private array $levelOptions;

    private array $typeOptions;

    private array $specificDatesOptions;

    private array $readStatusOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function fieldWithOptions(string $field): array
    {
        return $this->$field;
    }

    public function filterByUser(User $user): array
    {
        return ['recipient_id' => [$user->id]];
    }

    public function config()
    {
        $this->action = route('post.notification.search');

        $this->configModelForm(self::KEY_FORM);

        $this->levelOptions = $this->fieldFormBuilder->obtainNotificationLevels();

        $this->specificDatesOptions = $this->fieldFormBuilder->obtainSpecificDatesOptions();

        $this->readStatusOptions = $this->fieldFormBuilder->notificationReadStatusOptions();

        $this->fillTypeOptions();
    }

    protected function fillTypeOptions()
    {

        if (! $this->modelHasLevelSelected()) {

            //$this->typeOptions = $this->fieldFormBuilder->obtainNotificationTypes();
            $this->typeOptions = [];

            return;
        }

        $model = $this->model();
        $levels = [$model['level_id']];

        $this->typeOptions = $this->fieldFormBuilder->obtainNotificationTypesFromLevelIds($levels);
    }

    private function modelHasLevelSelected(): bool
    {

        $model = $this->model();

        if (! isset($model['level_id'])) {
            return false;
        }

        return is_numeric($model['level_id']);
    }
}
