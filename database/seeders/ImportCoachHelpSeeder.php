<?php

namespace Database\Seeders;

use App\Src\CoachDomain\CoachHelp\Model\CoachHelp;
use App\Src\CoachDomain\CoachHelp\Model\CoachHelpType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportCoachHelpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        $this->importTypes();

        $this->importHelp();

        DB::commit();
    }

    private function importTypes (){

        $new = new CoachHelpType();
        $new->id = 1;
        $new->name = 'Support';
        $new->save();

        $new = new CoachHelpType();
        $new->id = 2;
        $new->name = 'Materials';
        $new->save();

        $new = new CoachHelpType();
        $new->id = 3;
        $new->name = 'Syllabus';
        $new->save();
    }

    private function importHelp(){

        $supports =
            [
                ['type_id' => 1, 'description' => 'New user', 'url' => 'http://develop.linguameeting.com/documents/manager/ALTA_USUARIO.pdf'],

                ['type_id' => 1, 'description' => 'How to insert your availability - Spanish version', 'url' => 'http://develop.linguameeting.com/documents/manager/Disponabilidad_coach_spanish.mp4'],
                ['type_id' => 1, 'description' => 'How to insert your availability - English version', 'url' => 'http://develop.linguameeting.com/documents/manager/Disponibilidad_coach_english.mp4'],

                ['type_id' => 1, 'description' => "Coach's Manual - Spanish version (LinguaMeeting and Zoom)", 'url' => 'http://develop.linguameeting.com/documents/manager/MANUAL_DEL_COACH-_Zoom.pdf'],
                ["type_id" => 1, "description" => "Coach's Manual - English version (LinguaMeeting and Zoom)", "url" => "http://develop.linguameeting.com/documents/manager/COACH_HANDBOOK.pdf"],

                ["type_id" => 1, "description" => "Zoom issues - Spanish version", "url" => "http://develop.linguameeting.com/documents/manager/incidencias_zoom_spanish.docx"],
                ["type_id" => 1, "description" => "Zoom issues - English version", "url" => "http://develop.linguameeting.com/documents/manager/incidencias_zoom_english.docx"],

                ["type_id" => 1, "description" => " Coach's mission, first session presentation", "url" => "http://develop.linguameeting.com/documents/manager/coach_mission.pptx"],

                ["type_id" => 1, "description" => "FAQ Questions - Spanish version", "url" => "http://develop.linguameeting.com/documents/manager/FAQ_spanish.docx"],
                ["type_id" => 1, "description" => "FAQ Questions - English version", "url" => "http://develop.linguameeting.com/documents/manager/FAQ_english.docx"],
            ];

        $this->importItems($supports);

        $materials = [['type_id' => 2, 'description' => 'Link to Dropbox', 'url' => 'https://www.dropbox.com/sh/trcmmz7c2q3s4ti/AACgSDvl-iowL-QgCggE1__ea?dl=0',]];
        $this->importItems($materials);

        $syllabus = [['type_id' => 3, 'description' => 'Courses syllabi/assignments', 'url' => 'https://www.dropbox.com/sh/snzmskepfueg9ks/AABY4JlvM2qWGfXsA-R_kDq5a?dl=0',]];
        $this->importItems($syllabus);
    }

    private function importItems (array $items){

        foreach ($items as $item){

            $new = new CoachHelp();
            $new->coach_help_type_id = $item['type_id'];
            $new->description = $item['description'];
            $new->url = $item['url'];

            $new->save();
        }
    }
}
