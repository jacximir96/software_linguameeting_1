<?php
namespace App\Src\ActivityLog\Service\Properties;


use App\Src\StudentDomain\Enrollment\Model\Enrollment as EnrollmentModel;

class Enrollment implements Property
{

    private EnrollmentModel $enrollment;

    public function __construct (EnrollmentModel $enrollment){

        $this->enrollment = $enrollment;
    }

    public function buildProperty(string $key, string $title = ''): array
    {
        return [
            $key => [
                'type' => 'enrollment',
                'title' => $title,
                'id' => $this->enrollment->id,
            ]
        ];
    }
}
