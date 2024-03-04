<?php

namespace Database\Seeders;


use App\Src\StudentDomain\ExtraSessionType\Model\ExtraSessionType;
use App\Src\StudentDomain\MakeupType\Model\MakeupType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImportEnrollmentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = new MakeupType();
        $item->name = 'Coaching Form';
        $item->slug = 'coaching-form';
        $item->save();

        $item = new MakeupType();
        $item->name = 'Manager';
        $item->slug = 'manager';
        $item->save();

        $item = new MakeupType();
        $item->name = 'Instructor';
        $item->slug = 'instructor';
        $item->save();

        $item = new MakeupType();
        $item->name = 'Purchased';
        $item->slug = 'purchased';
        $item->save();


        $item = new ExtraSessionType();
        $item->name = 'Additional';
        $item->slug = 'additional';
        $item->save();
    }
}
