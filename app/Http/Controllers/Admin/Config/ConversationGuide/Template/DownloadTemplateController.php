<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\Template;

use App\Http\Controllers\Admin\Downloable;
use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\TemplateFile\Model\TemplateFile;
use App\Src\File\Service\PathBuilder;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class DownloadTemplateController extends Controller
{
    use Downloable;

    private PathBuilder $pathBuilder;

    public function __construct(PathBuilder $pathBuilder)
    {
        $this->pathBuilder = $pathBuilder;
    }

    public function __invoke(TemplateFile $file)
    {
        try {

            $filePath = $this->pathBuilder->buildAbsoluteFilePath(TemplateFile::KEY_PATH, $file->filename);

            return response()->download($filePath->path(), $file->original_name, $this->obtainDownlaodInfo($file));
        } catch (FileNotFoundException $exception) {
            flash('Conversation guide file not found')->error();

            return back();
        } catch (\Throwable $exception) {

            flash(trans('config.conversation_guide.error.download.error'))->error();

            return back();
        }
    }
}
