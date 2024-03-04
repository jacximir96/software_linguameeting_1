<?php

namespace Database\Seeders;

use App\Src\StudentDomain\StudentHelp\Model\StudentHelp;
use App\Src\StudentDomain\StudentHelp\Model\StudentHelpType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportStudentHelpSeeder extends Seeder
{
    public function run()
    {
        DB::beginTransaction();

        $this->importTypes();

        $this->importHelp();

        DB::commit();
    }

    private function importTypes (){

        $new = new StudentHelpType();
        $new->id = 1;
        $new->name = 'Common Tech Issues';
        $new->save();

        $new = new StudentHelpType();
        $new->id = 2;
        $new->name = 'General FAQs';
        $new->save();
    }

    private function importHelp(){

        $supports =
            [
                ['type_id' => 1, 'description' => 'Trouble with my webcam', 'url' => 'https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/20873217'],
                ['type_id' => 1, 'description' => 'Trouble with my microphone', 'url' => 'https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/20873217'],
                ['type_id' => 1, 'description' => 'Trouble accessing zoom', 'url' => 'https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/18055187'],

            ];

        $this->importItems($supports);

        $materials = [
            ['type_id' => 2, 'description' => 'How will I be graded?', 'url' => 'https://linguameeting.atlassian.net/servicedesk/customer/kb/view/1861320705',],
            ['type_id' => 2, 'description' => 'Can I get a refund?', 'url' => 'https://linguameeting.atlassian.net/servicedesk/customer/kb/view/1860763686',],
            ['type_id' => 2, 'description' => 'I can\'t make my session', 'url' => 'https://linguameeting.atlassian.net/servicedesk/customer/kb/view/15269914',],
            ['type_id' => 2, 'description' => 'I missed my session', 'url' => 'https://linguameeting.atlassian.net/servicedesk/customer/kb/view/1877082113',],

        ];
        $this->importItems($materials);

    }

    private function importItems (array $items){

        foreach ($items as $item){

            $new = new StudentHelp();
            $new->student_help_type_id = $item['type_id'];
            $new->description = $item['description'];
            $new->url = $item['url'];

            $new->save();
        }
    }
}
