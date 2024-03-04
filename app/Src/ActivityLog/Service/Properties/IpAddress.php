<?php
namespace App\Src\ActivityLog\Service\Properties;

class IpAddress implements Property
{

    private string $ip;

    public function __construct (string $ip){
        $this->ip = $ip;
    }

    public function buildProperty(string $key, string $title = ''): array
    {
        return [
            $key => [
                'title' => 'IP',
                'type' => 'ip',
                'value' => $this->ip,
            ]
        ];
    }
}
