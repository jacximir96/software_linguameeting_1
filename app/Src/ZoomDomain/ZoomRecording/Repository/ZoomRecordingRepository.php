<?php

namespace App\Src\ZoomDomain\ZoomRecording\Repository;

use App\Src\ZoomDomain\ZoomRecording\Model\ZoomRecording;
use App\Src\ZoomDomain\ZoomUser\Model\ZoomUser;

class ZoomRecordingRepository
{
    public function findLastItemsNotStartedByZoomUser(ZoomUser $zoomUser, int $numItems = 5)
    {
        return ZoomRecording::query()
            ->where('zoom_user_id', $zoomUser->id)
            ->orderBy('start', 'desc')
            ->take($numItems)
            ->get();
    }

    public function obtainByZoomUser(ZoomUser $zoomUser)
    {
        return ZoomRecording::query()
            ->where('zoom_user_id', $zoomUser->id)
            ->orderBy('start', 'desc')
            ->paginate(config('linguameeting.items_per_page_short'));
    }

    public function relations(): array
    {

        return [
            'session',
            'session.enrollmentSession',
            'session.enrollmentSession.enrollment',
            'session.enrollmentSession.enrollment.user',
            'session.enrollmentSession.enrollment.section',
            'session.enrollmentSession.enrollment.section.course',
            'session.enrollmentSession.enrollment.section.course.university',
            'zoomUser',
        ];
    }
}
