<?php

namespace App\Http\Controllers\ConversationGuide\Guide;

use App\Http\Controllers\Admin\Downloable;
use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\ChapterFile\Model\GuideChapterFile;
use App\Src\File\Service\PathBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class DownloadGuideChapterController extends Controller
{
    use Downloable;

    private PathBuilder $pathBuilder;

    public function __construct(PathBuilder $pathBuilder)
    {
        $this->pathBuilder = $pathBuilder;
    }

    public function __invoke(GuideChapterFile $file)
    {
       
        try {

            $filePath = $this->pathBuilder->buildAbsoluteFilePath(GuideChapterFile::KEY_PATH, $file->filename);

            return response()->download($filePath->path(), $file->original_name, $this->obtainDownlaodInfo($file));
        } catch (FileNotFoundException $exception) {
            flash('Conversation guide file not found')->error();

            return back();
        } catch (\Throwable $exception) {

            flash(trans('config.conversation_guide.error.download.error'))->error();

            return back();
        }
    }

    public function downloadChapter(Request $request){
       
        $file = GuideChapterFile::where('conversation_guide_chapter_id', $request->chapter)
            ->whereNull('deleted_at')
            ->first();
        
        try {

            $filePath = $this->pathBuilder->buildAbsoluteFilePath(GuideChapterFile::KEY_PATH, $file->filename);

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
