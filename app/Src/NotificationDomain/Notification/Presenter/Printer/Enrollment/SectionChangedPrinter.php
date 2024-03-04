<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Enrollment;


use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use Illuminate\Support\Collection;


class SectionChangedPrinter extends FieldPrinter
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
        return 'Section Changed';
    }

    public function sectionBefore ():string{
        return $this->obtainSection('before')->name;
    }

    public function sectionAfter ():string{
        return $this->obtainSection('after')->name;
    }

    public function change (string $moment):Collection{
        return collect();
    }

    private function obtainSection (string $moment):Section{

        $sectionId = $this->data()['values']['section_id']['values'][$moment];

        return SectionRepository::findTrashed($sectionId);
    }
}
