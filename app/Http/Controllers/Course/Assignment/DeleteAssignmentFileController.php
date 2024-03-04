<?php

namespace App\Http\Controllers\Course\Assignment;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\AssignmentFile\Action\DeleteAssignmentFileAction;
use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteAssignmentFileController extends Controller
{
    public function __invoke(AssignmentFile $assignmentFile)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteAssignmentFileAction::class);
            $action->handle($assignmentFile);

            DB::commit();

            flash('Assignment file deleted succesfully.')->success();

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when delete assignment file', [
                'assignmentFile' => $assignmentFile,
                'exception' => $exception,
            ]);

            flash('There is an error when deleting assignment file.')->error();

            return back();
        }
    }
}
