<?php

namespace Database\Seeders;

use App\Src\_Old\Model\GuidesChapters;
use App\Src\_Old\Model\GuidesType;
use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\GuideOrigin\Model\GuideOrigin;
use App\Src\ConversationGuideDomain\ChapterFile\Model\GuideChapterFile;
use App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImportGuideSeeder extends Seeder
{

    use TraitImport;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->importGuideOrigin();

        $this->importGuideType();

        $this->importEnglish();
    }

    private function importGuideOrigin (){

        $new = new GuideOrigin();
        $new->id = 1;
        $new->name = 'LinguaMeeting';
        $new->save();

        $new = new GuideOrigin();
        $new->id = 2;
        $new->name = 'LingroLearning';
        $new->save();
    }

    private function importGuideType (){

        $oldItems = GuidesType::orderBy('id_guide')->get();

        foreach ($oldItems as $oldItem){

            $new = new ConversationGuide();
            $new->id = $oldItem->id_guide;
            $new->guide_origin_id = $oldItem->guide_type;
            $new->language_id = $oldItem->id_language;
            $new->name = $oldItem->guide_name;
            $new->save();

            //file guide
            if ( ! empty($oldItem->download_zip)){

                /*
                $file = new ConversationGuideFile();
                $file->conversation_guide_id = $oldItem->id_guide;
                $file->filename = $oldItem->download_zip;
                $file->original_name = basename ($oldItem->download_zip);
                $file->mime = 'application/zip';
                $file->save();
                */
            }

            //chapters guide
            $oldChapters = GuidesChapters::where('id_guide', $oldItem->id_guide)->orderBy('id_chapter', 'asc')->get();

            foreach ($oldChapters as $oldChapter){

                $new = new Chapter();
                $new->id = $oldChapter->id_chapter;
                $new->conversation_guide_id = $oldChapter->id_guide;
                $new->name = $oldChapter->chapter_name;
                $new->save();


                $file = new GuideChapterFile();
                $file->conversation_guide_chapter_id = $oldChapter->id_chapter;
                $file->filename = $oldChapter->url;
                $file->original_name = basename ($oldChapter->url);

                $pathInfo = pathInfo($oldChapter->url);
                $file->mime = $this->obtainMime($pathInfo['extension']);
                $file->save();
            }
        }

        $guide = Chapter::find(29);
        $guide->name = '¿Cómo te cuidas?';
        $guide->save();
    }

    private function importEnglish (){

        $new = new ConversationGuide();
        $new->guide_origin_id = 1;
        $new->language_id = 4;
        $new->name = 'Linguameeting English';
        $new->save();

    }
}
