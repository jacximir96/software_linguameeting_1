<?php

namespace App\Http\Controllers\Student\Api\Accommodation;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Accommodation\Action\DeleteAccommodationAction;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteAccommodationController extends Controller
{
    public function __invoke(Enrollment $enrollment)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteAccommodationAction::class);
            $action->handle($enrollment);

            DB::commit();

            return response('Accommodation deleted successfully', 200);

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when deleting accommodation by instructor.', [
                'enrollment' => $enrollment,
                'exception' => $exception,
            ]);

            return response('Sorry, there is an error deleting accommodation.', 500);
        }
    }
}
