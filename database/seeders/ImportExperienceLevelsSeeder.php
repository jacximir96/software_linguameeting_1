<?php
namespace Database\Seeders;

use App\Src\_Old\Model\ExperiencesLevel;
use App\Src\ExperienceDomain\Level\Model\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportExperienceLevelsSeeder extends Seeder
{

    public function run()
    {

        DB::beginTransaction();

        $olds = ExperiencesLevel::all();

        foreach ($olds as $old){
            $level = new Level();
            $level->id = $old->level_id;
            $level->name = $old->level_name;
            //$level->save();
            dump($level);
        }


    }
}
