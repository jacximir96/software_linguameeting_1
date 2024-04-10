<?php

namespace App\Http\Controllers\ConversationGuide\Guide;

use App\Http\Controllers\Admin\Downloable;
use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\ConversationGuideDomain\ChapterFile\Model\GuideChapterFile;
use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\File\Service\PathBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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

    public function showChapter(Request $request) {
        $file = GuideChapterFile::where('conversation_guide_chapter_id', $request->chapter)
            ->whereNull('deleted_at')
            ->first();
        try {
            $filePath = $this->pathBuilder->buildAbsoluteFilePath(GuideChapterFile::KEY_PATH, $file->filename);
    
            return response()->file($filePath->path());
        } catch (FileNotFoundException $exception) {
            flash('Conversation guide file not found')->error();
            return back();
        } catch (\Throwable $exception) {
            flash(trans('config.conversation_guide.error.download.error'))->error();
            return back();
        }
    }
    
    public function downloadAllChapter(Request $request){

        $files = Chapter::where('conversation_guide_id', $request->chapter)
                ->join('conversation_guide_chapter_file', 'conversation_guide_chapter.id', '=', 'conversation_guide_chapter_file.conversation_guide_chapter_id')
                ->whereNull('conversation_guide_chapter_file.deleted_at')
                ->select('conversation_guide_chapter_file.*')
                ->get();

            $zipFile = tempnam(sys_get_temp_dir(), 'chapters');
            
            $zip = new ZipArchive();
            
            $zip->open($zipFile, ZipArchive::CREATE);
            $filesAdded = false;

            foreach ($files as $file) {
                $filePath = $this->pathBuilder->buildAbsoluteFilePath(GuideChapterFile::KEY_PATH, $file->filename);
                
                if (file_exists($filePath->path())) {
                    $zip->addFile($filePath->path(), $file->original_name);
                    $filesAdded = true;
                } 

            }
           
            if ($filesAdded == false) {
                $zip->close();

                flash('There are no files in this guide')->error();
                return back();

            }
            
            $zip->close();
        
            $guide = ConversationGuide::find($request->chapter);
            $nameFile = $guide->name . '.zip';
            return response()->download($zipFile, $nameFile)->deleteFileAfterSend(true);
        
        
        
    }
}
