<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Section;


use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;


class InstructorPrinter extends FieldPrinter
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
        return 'instructor_id';
    }

    public function nameField(): string
    {
        return 'Instructor';
    }

    public function change (string $moment):Collection{

        $changes = collect();

        if (isset($this->data()['values'][$this->keyField()])){

            $instructorId = $this->data()['values'][$this->keyField()]['values'][$moment];
            $instructor = User::find($instructorId);

            $value = new Value($this->nameField(), $instructor->writeFullName());
            $changes->push($value);
        }

        return $changes;
    }
}
