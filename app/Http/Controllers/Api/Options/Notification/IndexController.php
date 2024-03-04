<?php

namespace App\Http\Controllers\Api\Options\Notification;

use App\Http\Controllers\Controller;
use App\Src\NotificationDomain\NotificationLevel\Model\NotificationLevel;
use App\Src\NotificationDomain\NotificationType\Repository\NotificationTypeRepository;


class IndexController extends Controller
{

    private NotificationTypeRepository $notificationTypeRepository;

    public function __construct (NotificationTypeRepository $notificationTypeRepository){

        $this->notificationTypeRepository = $notificationTypeRepository;
    }

    public function obtainTypesFromLevel(NotificationLevel $level)
    {
        $types = $this->notificationTypeRepository->obtainFromLevel($level)->map(function ($type) {
            return [
                'id' => $type->id,
                'name' => $type->name,
            ];
        });

        return response()->json(['items' => $types]);
    }
}
