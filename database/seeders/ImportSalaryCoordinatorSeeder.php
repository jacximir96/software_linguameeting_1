<?php

namespace Database\Seeders;

use App\Src\_Old\Model\CoachesCoorSalary;
use App\Src\CoachDomain\SemesterFinished\Model\SemesterFinished;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportSalaryCoordinatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::beginTransaction();


        $coorSalaries = CoachesCoorSalary::all();

        foreach ($coorSalaries as $coorSalary){

            $coach = User::find($coorSalary->id_user_coach);

            if ($coach){

                $finished = new SemesterFinished();
                $finished->coach_id = $coach->id;
                $finished->semester_1 = $coorSalary->semestre_1;
                $finished->semester_2 = $coorSalary->semestre_2;
                $finished->save();
            }
        }

        DB::commit();
    }
}
