<?php

namespace Database\Seeders;

use App\Src\HelpDomain\IssueType\Model\IssueType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportIssueTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create ('Other');
        $this->create ('Registration');
        $this->create ('Payments');
        $this->create ('Scheduling');
        $this->create ('Make-ups');
        $this->create ('Tech Issues');
    }

    private function create (string $name){

        $new = new IssueType();
        $new->name = $name;
        $new->save();
    }
}
