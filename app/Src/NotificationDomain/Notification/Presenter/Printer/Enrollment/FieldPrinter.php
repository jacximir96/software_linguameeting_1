<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Enrollment;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\NotificationDomain\Notification\Presenter\Printer\NotificationPrinter;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;


abstract class FieldPrinter implements NotificationPrinter
{

    private array $data;

    public function __construct (array $data){

        $this->data = $data;
    }

    abstract public function key(): string;

    abstract public function keyField(): string;

    abstract public function nameField(): string;

    abstract public function change(string $moment): Collection;


    protected function data():array{
        return $this->data;
    }

    public function course ():Course{
        return $this->enrollment()->course();
    }

    public function university():University{
        return $this->course()->university;
    }

    public function section ():Section{
       return $this->enrollment()->section;
    }

    public function enrollment ():Enrollment{

        $enrollmentId = $this->data['values']['enrollment_id']['values']['id'];

        return EnrollmentRepository::findTrashed($enrollmentId);

    }

    public function before ():Collection{
        return $this->change('before');
    }

    public function after ():Collection{
        return $this->change('after');
    }
}
