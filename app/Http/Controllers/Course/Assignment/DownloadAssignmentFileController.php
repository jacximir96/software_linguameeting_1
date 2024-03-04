<?php

namespace App\Http\Controllers\Course\Assignment;

use App\Http\Controllers\Admin\Downloable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;
use App\Src\File\Service\PathBuilder;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class DownloadAssignmentFileController extends Controller
{
    use Downloable;

    private PathBuilder $pathBuilder;

    public function __construct(PathBuilder $pathBuilder)
    {
        $this->pathBuilder = $pathBuilder;
    }

    public function __invoke(AssignmentFile $assignmentFile)
    {
        try {

            $filePath = $this->pathBuilder->buildAbsoluteFilePath(AssignmentFile::KEY_PATH, $assignmentFile->filename);

            return response()->download($filePath->path(), $assignmentFile->original_name, $this->obtainDownlaodInfo($assignmentFile));
        } catch (FileNotFoundException $exception) {
            flash('Assignment file not found')->error();

            return back();
        } catch (\Throwable $exception) {

            flash(trans('linguameeting_common.file.download.error'))->error();

            return back();
        }
    }
}
