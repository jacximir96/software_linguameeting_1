<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Course;


use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use Illuminate\Support\Collection;

class ConversationGuidePrinter extends FieldPrinter
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
        return 'conversation_guide_id';
    }

    public function nameField(): string
    {
        return 'Conversation Guide';
    }

    public function change (string $moment):Collection{

        $changes = collect();

        if (isset($this->data()['values'][$this->keyField()])){

            $conversationGuideId = $this->data()['values'][$this->keyField()]['values'][$moment];
            $conversationGuide = ConversationGuide::find($conversationGuideId);

            $value = new Value($this->nameField(), $conversationGuide->name);
            $changes->push($value);
        }

        return $changes;
    }
}
