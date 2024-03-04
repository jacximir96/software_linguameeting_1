<?php

namespace Database\Seeders;

use App\Src\InstructorDomain\InstructorHelp\Model\InstructorHelpType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddInstructorTypeHelpOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = new InstructorHelpType();
        $type->name = 'Common Tech Issues';
        $type->save();

        $type = new InstructorHelpType();
        $type->name = 'General FAQs';
        $type->save();
    }
}
