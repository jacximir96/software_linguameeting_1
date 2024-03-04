<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Course;


use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use Illuminate\Support\Collection;

class DatesNotifierPrinter extends FieldPrinter
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
        return 'start_date';
    }

    public function nameField(): string
    {
        return 'Start Date';
    }

    public function change (string $moment):Collection{

        $changes = collect();

        if (isset($this->data()['values']['start_date'])){
            $value = new Value('Start Date', $this->data()['values']['start_date']['values'][$moment]);
            $changes->push($value);
        }

        if (isset($this->data()['values']['end_date'])){
            $value = new Value('End Date', $this->data()['values']['end_date']['values'][$moment]);
            $changes->push($value);
        }

        return $changes;
    }
}
