<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\File;

use App\Http\Controllers\Admin\Downloable;
use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile;
use App\Src\File\Service\PathBuilder;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class DownloadController extends Controller
{
    use Downloable;

    private PathBuilder $pathBuilder;

    public function __construct(PathBuilder $pathBuilder)
    {
        $this->pathBuilder = $pathBuilder;
    }

    public function __invoke(ConversationGuideFile $file)
    {
        try {

            $filePath = $this->pathBuilder->buildAbsoluteFilePath(ConversationGuideFile::KEY_PATH, $file->filename);

            return response()->download($filePath->path(), $file->original_name, $this->obtainDownlaodInfo($file));
        } catch (FileNotFoundException $exception) {
            flash('Conversation guide file not found')->error();

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when download conversation guide file.', [
                'conversationGuideFile' => $file,
                'exception' => $exception,
            ]);

            flash(trans('config.conversation_guide.error.download.error'))->error();

            return back();
        }
    }
}
