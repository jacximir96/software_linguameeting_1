<?php

namespace App\Http\Controllers\Public\Experience;

use App\Http\Controllers\Admin\Downloable;
use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFile;
use App\Src\File\Service\PathBuilder;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class DownloadVocabularyController extends Controller
{
    use Downloable;

    private PathBuilder $pathBuilder;

    public function __construct(PathBuilder $pathBuilder)
    {
        $this->pathBuilder = $pathBuilder;
    }

    public function __invoke(ExperienceFile $experienceFile)
    {
        try {

            $filePath = $this->pathBuilder->buildAbsoluteFilePath(ExperienceFile::KEY_PATH, $experienceFile->filename);

            return response()->download($filePath->path(), $experienceFile->original_name, $this->obtainDownlaodInfo($experienceFile));
        } catch (FileNotFoundException $exception) {
            flash('Experience file not found')->error();

            return back();
        } catch (\Throwable $exception) {

            flash(trans('linguameeting_common.file.download.error'))->error();

            return back();
        }
    }
}
