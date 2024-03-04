<?php

namespace App\Http\Controllers\Course\Assignment;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingForm\Action\CourseAssignment\OneGuideForWeekOneOnOneUpdateAction;
use App\Src\CourseDomain\CoachingForm\Request\AssignmentRequest;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Section\Model\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateGuideForWeekOneOnOneController extends Controller
{
    public function __invoke(AssignmentRequest $request, Section $section, CoachingWeek $coachingWeek)
    {

        try {
            DB::beginTransaction();

            $action = app(OneGuideForWeekOneOnOneUpdateAction::class);
            $action->handle($request, $section, $coachingWeek);

            DB::commit();

            return response('Guide assigned successfully', 200);

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update guide in week with one one one', [
                'section' => $section,
                'coachingWeek' => $coachingWeek,
                'request' => $request,
                'exception' => $exception,
            ]);

            return response('', 500);
        }
    }
}
