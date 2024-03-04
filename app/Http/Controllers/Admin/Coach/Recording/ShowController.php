<?php

namespace App\Http\Controllers\Admin\Coach\Recording;

use App\Http\Controllers\Controller;
use App\Src\UserDomain\User\Model\User;
use App\Src\ZoomDomain\ZoomRecording\Model\ZoomRecording;
use App\Src\ZoomDomain\ZoomRecording\Repository\ZoomRecordingRepository;

class ShowController extends Controller
{
    private ZoomRecordingRepository $zoomRecordingRepository;

    public function __construct(ZoomRecordingRepository $zoomRecordingRepository)
    {

        $this->zoomRecordingRepository = $zoomRecordingRepository;
    }

    public function __invoke(ZoomRecording $zoomRecording)
    {

        $zoomUser = $zoomRecording->zoomUser;

        if (is_null($zoomUser)) {
            abort(404);
        }

        $zoomRecording->load($this->zoomRecordingRepository->relations());


        view()->share([
            'recording' => $zoomRecording,
        ]);

        return view('admin.coach.zoom-recording.show');
    }
}
