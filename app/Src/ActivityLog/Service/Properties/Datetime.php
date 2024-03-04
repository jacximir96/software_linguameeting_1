<?php
namespace App\Src\ActivityLog\Service\Properties;

use Carbon\Carbon;


class Datetime implements Property
{

    private Carbon $moment;


    public function __construct (Carbon $moment){
        $this->moment = $moment;
    }

    public function buildProperty(string $key, string $title = ''): array
    {
        return [
            $key => [
                'type' => 'datetime',
                'title' => $title,
                'value' => $this->moment->toDateTimeString(),
            ],
        ];
    }
}
