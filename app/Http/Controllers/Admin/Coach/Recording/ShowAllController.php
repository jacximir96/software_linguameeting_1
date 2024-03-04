<?php

namespace App\Http\Controllers\Admin\Coach\Recording;

use App\Http\Controllers\Controller;
use App\Src\UserDomain\User\Model\User;
use App\Src\ZoomDomain\ZoomRecording\Repository\ZoomRecordingRepository;

class ShowAllController extends Controller
{
    private ZoomRecordingRepository $zoomRecordingRepository;

    public function __construct(ZoomRecordingRepository $zoomRecordingRepository)
    {

        $this->zoomRecordingRepository = $zoomRecordingRepository;
    }

    public function __invoke(User $coach)
    {
        $zoomUser = $coach->zoomUser;

        if (is_null($zoomUser)) {
            abort(404);
        }

        $recordings = $this->zoomRecordingRepository->obtainByZoomUser($zoomUser);

        view()->share([
            'coach' => $coach,
            'recordings' => $recordings,
            'zoomUser' => $zoomUser,
        ]);

        return view('admin.coach.zoom-recording.show_all');
    }
}
