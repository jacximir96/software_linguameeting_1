<?php

namespace App\Http\Controllers\Coach\Feedback\Manager;

use App\Http\Controllers\Admin\Downloable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluationFile\Model\ManagerEvaluationFile;
use App\Src\File\Service\PathBuilder;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class DownloadFileController extends Controller
{
    use Downloable;

    private PathBuilder $pathBuilder;

    public function __construct(PathBuilder $pathBuilder)
    {
        $this->pathBuilder = $pathBuilder;
    }

    public function __invoke(ManagerEvaluationFile $file)
    {
        try {
            $filePath = $this->pathBuilder->buildAbsoluteFilePath(ManagerEvaluationFile::KEY_PATH, $file->filename());

            return response()->download($filePath->path(), $file->originalName(), $this->obtainDownlaodInfo($file));
        } catch (FileNotFoundException $exception) {
            flash('Feedback file not found')->error();

            return back();
        } catch (\Throwable $exception) {
            flash(trans('coach.evaluation_manager.download.error'))->error();

            return back();
        }
    }
}
