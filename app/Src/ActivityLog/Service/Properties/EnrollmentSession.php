<?php
namespace App\Src\ActivityLog\Service\Properties;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession as EnrollmentSessionModel;


class EnrollmentSession implements Property
{

    private EnrollmentSessionModel $enrollmentSession;

    public function __construct (EnrollmentSessionModel $enrollmentSession){

        $this->enrollmentSession = $enrollmentSession;
    }

    public function buildProperty(string $key, string $title = ''): array
    {
        return [
            $key => [
                'type' => 'enrollment_session',
                'title' => $title,
                'id' => $this->enrollmentSession->id,
            ]
        ];
    }
}
