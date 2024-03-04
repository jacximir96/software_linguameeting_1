<?php

namespace App\Http\Controllers\Messaging\File;

use App\Http\Controllers\Admin\Downloable;
use App\Http\Controllers\Controller;
use App\Src\File\Service\PathBuilder;
use App\Src\MessagingDomain\File\Model\MessageFile;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;


class DownloadThreadFileController extends Controller
{
    use Downloable;

    private PathBuilder $pathBuilder;

    public function __construct(PathBuilder $pathBuilder)
    {
        $this->pathBuilder = $pathBuilder;
    }

    public function __invoke(MessageFile $threadFile)
    {
        try {

            $filePath = $this->pathBuilder->buildAbsoluteFilePath(MessageFile::KEY_PATH, $threadFile->filename);

            return response()->download($filePath->path(), $threadFile->original_name, $this->obtainDownlaodInfo($threadFile));
        } catch (FileNotFoundException $exception) {
            flash('Attach file not found')->error();

            return back();
        } catch (\Throwable $exception) {

            flash(trans('linguameeting_common.file.download.error'))->error();

            return back();
        }
    }
}
