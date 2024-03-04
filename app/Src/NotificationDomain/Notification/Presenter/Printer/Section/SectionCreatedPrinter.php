<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Section;


use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;


class SectionCreatedPrinter extends FieldPrinter
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
        return 'new';
    }

    public function nameField(): string
    {
        return 'New Section';
    }

    public function change (string $moment):Collection{

        $changes = collect();

        if (isset($this->data()['values'][$this->keyField()])){

            $value = new Value($this->nameField(), $this->data()['values'][$this->keyField()]['values'][$moment]);
            $changes->push($value);
        }


        return $changes;
    }
}
