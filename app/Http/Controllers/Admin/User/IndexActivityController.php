<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Src\ActivityLog\Model\Activity;
use App\Src\ActivityLog\Repository\ActivityRepository;
use App\Src\ActivityLog\Repository\StudentActivityRepository;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;


class IndexActivityController extends Controller
{
    private StudentActivityRepository $studentActivityRepository;

    public function __construct (StudentActivityRepository $studentActivityRepository){

        $this->studentActivityRepository = $studentActivityRepository;
    }

    public function __invoke(User $user)
    {
        try {

            view()->share([
                'activity' => $this->studentActivityRepository->obtainActivity($user),
                'timezone' => $this->userTimezone(),
            ]);

           return view('user.activity.index');

        } catch (\Throwable $exception) {

            Log::error('There is an error showing user activity.', [
                'user' => $user,
                'exception' => $exception,
            ]);

            flash(trans('user.throttle.remove_error'))->error();

            return back();

        }
    }
}
