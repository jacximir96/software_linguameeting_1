<?php

namespace App\Http\Controllers\Api\Coach\Semester;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SemesterFinished\Action\ChangeSemesterFinishedAction;
use App\Src\CoachDomain\SemesterFinished\Request\ChangeFinishedRequest;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;


class ChangeFinishedController extends Controller
{
    public function __invoke(ChangeFinishedRequest $request, User $coach)
    {

        try {

            $action = app(ChangeSemesterFinishedAction::class);
            $action->handle($coach, $request->semester_number, (bool)$request->is_checked);

            return response('Semester finished changed successfully', 200);

        } catch (\Throwable $exception) {

            Log::error('There is an error when changing semester finished from coach', [
                'coach' => $coach,
                'request' => $request,
                'exception' => $exception,
            ]);

            return response('Error while changing semester finished', 500);
        }
    }
}
