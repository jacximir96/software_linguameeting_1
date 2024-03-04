<?php

namespace Database\Seeders;

use App\Src\_Old\Model\UniversityTeachers;
use App\Src\UniversityDomain\Instructor\Model\UniversityInstructor;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImportUniversityInstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $olds = UniversityTeachers::orderBy('id_university','asc')->get();

        foreach ($olds as $old){

            $user = User::find($old->id_user);

            //todo remove this check
            if (is_null($user)){
                continue;
            }

            $new = new UniversityInstructor();
            $new->university_id = $old->id_university;
            $new->instructor_id = $old->id_user;
            $new->save();
        }
    }
}
