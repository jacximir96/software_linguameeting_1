<?php
namespace App\Src\ConversationPackageDomain\Package\Service;

use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;


class ConversationPackageForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $sessionTypeOptions;

    private LinguaMoney $linguaMoney;

    public function __construct(FieldFormBuilder $fieldFormBuilder, LinguaMoney $linguaMoney)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->linguaMoney = $linguaMoney;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configForCreate()
    {
        $this->action = route('post.admin.config.conversation_package.create');

        $this->configOptions();
    }

    public function configForEdit(ConversationPackage $conversationPackage)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.config.conversation_package.update', $conversationPackage->id);

        $this->model = $conversationPackage->toArray();
        $this->model['price'] = $this->linguaMoney->formatForFormField($conversationPackage->price);

        $this->configOptions();
    }

    private function configOptions (){
        $this->sessionTypeOptions = $this->fieldFormBuilder->obtainSessionTypeOptions();
    }
}
