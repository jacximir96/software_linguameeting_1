<?php

namespace Database\Seeders;

use App\Src\_Old\Model\RatesOptions;
use App\Src\_Old\Model\SessionsRate;
use App\Src\_Old\Model\SessionsRateOptions;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\ReviewOption\Model\ReviewOption;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Model\CoachReview;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Model\CoachReviewOption;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        $this->importOptions();

        //$this->importSessionsRates();

        DB::commit();
    }

    private function importOptions (){

        $olds = RatesOptions::all();

        foreach ($olds as $old){

            $new = new ReviewOption();
            $new->id = $old->rate_option_id;
            $new->name = $old->name;
            $new->save();
        }
    }

    private function importSessionsRates (){

        SessionsRate::orderBy('rate_id')
            ->take(100)
            ->chunk(100, function ($sessionsRateOld){

                foreach ($sessionsRateOld as $sessionRateOld){

                    $coach = User::find($sessionRateOld->coach_id);

                    if ($coach){

                        $new = new CoachReview();
                        $new->id = $sessionRateOld->rate_id;
                        $new->coach_id = $sessionRateOld->coach_id;
                        //todo quitar la siguiente asignación
                        $new->session_id = 27;
                        $new->stars = $sessionRateOld->stars;
                        $new->comment = $sessionRateOld->comment;
                        $new->save();

                        $optionsOld = SessionsRateOptions::where('rate_id', $sessionRateOld->rate_id)->get();

                        foreach ($optionsOld as $optionOld){

                            if ($optionOld->value){
                                $newOption = new CoachReviewOption();
                                $newOption->coach_review_id = $new->id;
                                $newOption->review_option_id = $optionOld->option_id;
                                $newOption->save();
                            }
                        }
                    }

                }
            });
    }
}
