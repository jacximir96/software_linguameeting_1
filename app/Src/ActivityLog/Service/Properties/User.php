<?php
namespace App\Src\ActivityLog\Service\Properties;

use App\Src\UserDomain\User\Model\User as UserModel;

class User implements Property
{

    private UserModel $user;

    public function __construct (UserModel $user){

        $this->user = $user;
    }

    public function buildProperty(string $key, string $title = ''): array
    {
        return [
            $key => [
                'title' => $title,
                'type' => 'user',
                'full_name' => $this->user->writeFullName(),
                'id' => $this->user->id,
            ]
        ];
    }
}
