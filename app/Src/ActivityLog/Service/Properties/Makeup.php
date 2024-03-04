<?php
namespace App\Src\ActivityLog\Service\Properties;


use App\Src\StudentDomain\Makeup\Model\Makeup as MakeupModel;

class Makeup implements Property
{

    private MakeupModel $makeup;

    public function __construct (MakeupModel $makeup){

        $this->makeup = $makeup;
    }

    public function buildProperty(string $key, string $title = ''): array
    {
        return [
            $key => [
                'type' => 'makeup',
                'title' => $title,
                'id' => $this->makeup->id,
            ]
        ];
    }
}
