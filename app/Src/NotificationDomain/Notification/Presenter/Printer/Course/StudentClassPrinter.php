<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Course;


use App\Src\Localization\Language\Model\Language;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use Illuminate\Support\Collection;

class StudentClassPrinter extends FieldPrinter
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
        return 'student_class';
    }

    public function nameField(): string
    {
        return 'Num. Students';
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
