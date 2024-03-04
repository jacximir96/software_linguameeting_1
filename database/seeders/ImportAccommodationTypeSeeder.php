<?php

namespace Database\Seeders;

use App\Src\StudentDomain\AccommodationType\Model\AccommodationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImportAccommodationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $new = new AccommodationType();
        $new->description = 'Restricted use of camera';
        $new->save();

        $new = new AccommodationType();
        $new->description = 'Exclusive use of the camera';
        $new->save();

        $new = new AccommodationType();
        $new->description = 'Stress';
        $new->individual_session = true;
        $new->save();



    }


}
