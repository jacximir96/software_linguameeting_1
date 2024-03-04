<?php

namespace Database\Seeders;

use App\Src\_Old\Model\Country;
use App\Src\_Old\Model\University;
use App\Src\_Old\Model\UniversityLevels;
use App\Src\UniversityDomain\Level\Model\Level;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImportUniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $itemsOld = UniversityLevels::all();
        foreach ($itemsOld as $itemOld){

            $newItem = new Level();
            $newItem->id = $itemOld->level_id;
            $newItem->name = $itemOld->level_name;

            if ($newItem->id == 1){
                $newItem->name = '1. Universidades pilotos y adopciones';
            }

            $newItem->save();
        }


        $itemsOld = University::all();
        foreach ($itemsOld as $itemOld){

            $newItem = new \App\Src\UniversityDomain\University\Model\University();
            $newItem->id = $itemOld->id_university;
            $newItem->university_level_id = $itemOld->level;
            $newItem->timezone_id = $itemOld->id_zone;
            $newItem->country_id = $itemOld->id_country;

            $newItem->name = $itemOld->name_university;
            $newItem->internal_comment = $itemOld->internal_comment;

            $newItem->created_at = $itemOld->created ? Carbon::parse($itemOld->created, 'Europe/Madrid')->setTimezone('UTC') : null;
            $newItem->updated_at = $itemOld->updated ? Carbon::parse($itemOld->updated, 'Europe/Madrid')->setTimezone('UTC') : null;
            $newItem->deleted_at = $itemOld->date_erased ? Carbon::parse($itemOld->date_erased, 'Europe/Madrid')->setTimezone('UTC') : null;

            $newItem->save();
        }
    }
}
