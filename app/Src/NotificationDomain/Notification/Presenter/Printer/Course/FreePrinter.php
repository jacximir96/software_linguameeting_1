<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Course;

use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use Illuminate\Support\Collection;


class FreePrinter extends FieldPrinter
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
        return 'is_free';
    }

    public function nameField(): string
    {
        return 'Is Free';
    }

    public function change (string $moment):Collection{

        $changes = collect();

        if (isset($this->data()['values'][$this->keyField()])){

            $value = (bool)$this->data()['values'][$this->keyField()]['values'][$moment];
            $value = $value ? 'Yes' : 'No';

            $value = new Value($this->nameField(), $value);
            $changes->push($value);
        }

        return $changes;
    }
}
