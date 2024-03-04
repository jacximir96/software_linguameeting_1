<?php
namespace App\Src\ActivityLog\Service\Properties;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session as SessionModel;

class Session implements Property
{
    private SessionModel $session;

    public function __construct(SessionModel $session){

        $this->session = $session;
    }

    public function buildProperty(string $key, string $title = ''): array
    {
        return [
            $key => [
                'title' => $title,
                'type' => 'session',
                'id' => $this->session->id,
            ]
        ];
    }
}
