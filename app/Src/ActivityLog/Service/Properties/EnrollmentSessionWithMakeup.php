<?php
namespace App\Src\ActivityLog\Service\Properties;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;


class EnrollmentSessionWithMakeup implements Property
{

    private EnrollmentSession $enrollmentSession;

    public function __construct (EnrollmentSession $enrollmentSession){

        $this->enrollmentSession = $enrollmentSession;
    }

    public function buildProperty(string $key, string $title = ''): array
    {

        return [
            $key => [
                'title' => $title,
                'type' => 'enrollment_session',
                'id' => $this->enrollmentSession->id,
            ]
        ];
    }
}
