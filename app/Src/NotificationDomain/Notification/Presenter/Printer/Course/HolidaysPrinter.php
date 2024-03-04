<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Course;

use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use Illuminate\Support\Collection;


class HolidaysPrinter extends FieldPrinter
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
        return '';
    }

    public function nameField(): string
    {
        return 'Holidays';
    }

    public function change (string $moment):Collection{

        $changes = collect();

        if (isset($this->data()['values'])){
            foreach ($this->data()['values'] as $key => $changeData){
                if (str_starts_with($key, 'new_')) {
                    $value = new Value('new', $changeData['values']['after']);
                    $changes->push($value);
                }

                if (str_starts_with($key, 'deleted_')) {
                    $value = new Value('deleted', $changeData['values']['before']);
                    $changes->push($value);
                }
            }
        }

        return $changes;
    }
}
