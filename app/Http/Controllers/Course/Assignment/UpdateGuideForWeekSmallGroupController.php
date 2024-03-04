<?php

namespace App\Http\Controllers\Course\Assignment;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingForm\Action\CourseAssignment\OneGuideForWeekSmallGroupUpdateAction;
use App\Src\CourseDomain\CoachingForm\Request\AssignmentRequest;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateGuideForWeekSmallGroupController extends Controller
{
    public function __invoke(AssignmentRequest $request, CoachingWeek $coachingWeek)
    {

        try {
            DB::beginTransaction();

            $action = app(OneGuideForWeekSmallGroupUpdateAction::class);
            $action->handle($request, $coachingWeek);

            DB::commit();

            return response('Guide assigned successfully', 200);

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update one guide in week with small group', [
                'coachingWeek' => $coachingWeek,
                'request' => $request,
                'exception' => $exception,
            ]);

            return response('', 500);

        }
    }
}
