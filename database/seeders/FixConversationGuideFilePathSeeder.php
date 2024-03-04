<?php

namespace Database\Seeders;

use App\Src\ConversationGuideDomain\ChapterFile\Model\GuideChapterFile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FixConversationGuideFilePathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        $files = GuideChapterFile::all();
        foreach ($files as $file){
            $pathinfo = pathinfo($file->filename);
            $file->filename = $pathinfo['basename'];
            $file->save();
        }
        DB::commit();
    }
}
