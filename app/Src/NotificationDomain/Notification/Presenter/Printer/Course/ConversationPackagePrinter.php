<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Course;

use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use Illuminate\Support\Collection;

class ConversationPackagePrinter extends FieldPrinter
{

    public function __construct (array $data){
        parent::__construct($data);
    }

    public function key(): string
    {
        return $this->data()['key'];
    }

    public function keyField(): string
    {
        return 'conversation_package_id';
    }

    public function nameField(): string
    {
        return 'Conversation Package';
    }

    public function change (string $moment):Collection{

        $changes = collect();

        if (isset($this->data()['values'][$this->keyField()])){

            $conversationPackageId = $this->data()['values'][$this->keyField()]['values'][$moment];
            $conversationPackage = ConversationPackage::find($conversationPackageId);

            $value = new Value($this->nameField(), $conversationPackage->name);
            $changes->push($value);
        }

        return $changes;
    }
}
