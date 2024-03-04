<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Course;


use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use App\Src\TimeDomain\Semester\Model\Semester;
use Illuminate\Support\Collection;

class SemesterPrinter extends FieldPrinter
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
        return 'semester_id';
    }

    public function nameField(): string
    {
        return 'Semester';
    }

    public function change (string $moment):Collection{

        $changes = collect();

        if (isset($this->data()['values'][$this->keyField()])){

            $semesterId = $this->data()['values'][$this->keyField()]['values'][$moment];
            $semester = Semester::find($semesterId);

            $value = new Value($this->nameField(), $semester->name);
            $changes->push($value);
        }

        return $changes;
    }
}
