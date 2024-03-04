<?php

namespace Database\Seeders;

use App\Src\_Old\Model\Participation;
use App\Src\_Old\Model\PreparedClass;
use App\Src\_Old\Model\Puntuality;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\ParticipationType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PreparedClassType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PunctualityType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportStudentReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->importPuntuality();

        $this->importPrepared();

        $this->importParticipation();
    }

    private function importPuntuality (){

        $olds = Puntuality::all();

        foreach ($olds as $old){

            $new = new PunctualityType();
            $new->id = $old->id_puntuality;
            $new->description = $old->description_puntuality;
            $new->description_student = $old->text_puntuality_student;
            $new->description_instructor = $old->text_puntuality_instructor;
            $new->description_report = $old->text_puntuality_report;

            $new->save();
        }
    }

    private function importPrepared (){

        $olds = PreparedClass::all();

        foreach ($olds as $old){

            $new = new PreparedClassType();
            $new->id = $old->id_prepared;
            $new->description = $old->description_prepared;
            $new->description_student = $old->text_prepared_student;
            $new->description_instructor = $old->text_prepared_instructor;
            $new->description_report = $old->text_prepared_report;

            $new->save();
        }
    }

    private function importParticipation (){

        $olds = Participation::all();

        foreach ($olds as $old){

            $new = new ParticipationType();
            $new->id = $old->id_participation;
            $new->description = $old->description_participation;
            $new->description_student = $old->text_participation_student;
            $new->description_instructor = $old->text_participation_instructor;
            $new->description_report = $old->text_participation_report;

            $new->save();
        }
    }
}
