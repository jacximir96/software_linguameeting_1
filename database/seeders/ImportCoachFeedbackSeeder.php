<?php

namespace Database\Seeders;

use App\Src\_Old\Model\FeedbacksCoaches;
use App\Src\_Old\Model\FeedbacksObservations;
use App\Src\_Old\Model\FeedbacksSubtypes;
use App\Src\_Old\Model\FeedbacksSuggestions;
use App\Src\_Old\Model\FeedbacksTypes;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use App\Src\CoachDomain\FeedbackDomain\FeedbackObservation\Model\FeedbackObservation;
use App\Src\CoachDomain\FeedbackDomain\FeedbackSubtype\Model\FeedbackSubtype;
use App\Src\CoachDomain\FeedbackDomain\FeedbackSuggestion\Model\FeedbackSuggestion;
use App\Src\CoachDomain\FeedbackDomain\FeedbackType\Model\FeedbackType;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportCoachFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        $this->importTypes();

        $this->importTSubtypes();

        $this->importObservations();

        $this->importSuggestions();

        $this->importCoachFeedback();

        DB::commit();
    }

    private function importTypes (){

        $olds = FeedbacksTypes::all();

        foreach ($olds as $old){

            $new = new FeedbackType();
            $new->id = $old->id_feed_type;
            $new->es_title = $old->title_spa;
            $new->eng_title = $old->title_eng;
            $new->save();
        }
    }

    private function importTSubtypes (){

        $olds = FeedbacksSubtypes::all();

        foreach ($olds as $old){

            $new = new FeedbackSubtype();
            $new->id = $old->id_feed_subtype;
            $new->type_id = $old->id_type;
            $new->es_title = $old->title_spa;
            $new->eng_title = $old->title_eng;
            $new->save();
        }
    }

    private function importObservations (){

        $olds = FeedbacksObservations::all();

        foreach ($olds as $old){

            $new = new FeedbackObservation();
            $new->id = $old->id_feed_obs;
            $new->type_id = $old->id_feed_type;
            $new->subtype_id = $old->id_feed_sub;
            $new->es_title = $old->title_spa;
            $new->eng_title = $old->title_eng;

            $new->save();
        }
    }

    private function importSuggestions (){

        $olds = FeedbacksSuggestions::all();

        foreach ($olds as $old){

            $new = new FeedbackSuggestion();
            $new->id = $old->id_feed_sugg;
            $new->type_id = $old->id_feed_type;
            $new->subtype_id = $old->id_feed_sub;
            $new->es_title = $old->title_spa;
            $new->eng_title = $old->title_eng;

            $new->save();
        }
    }

    private function importCoachFeedback(){

        $olds = FeedbacksCoaches::all();

        foreach ($olds as $old){

            $coach = User::find($old->id_coach);

            if (is_null($coach)){
                continue;
            }

            try{

                $new = new CoachFeedback();
                $new->id = $old->id_feed_coach;
                $new->coach_id = $old->id_coach;
                $new->moment = Carbon::parse($old->date_feedback);


                $json = str_replace('"', "'", $old->feedback_json);
                $json = str_replace("{'", '{"', $json);
                $json = str_replace("':'", '":"', $json);
                $json = str_replace("','", '","', $json);
                $json = str_replace("':", '":', $json);
                $json = str_replace("'}", '"}', $json);
                $json = str_replace(",'", ',"', $json);
                $json = preg_replace('/[[:cntrl:]]/', '', $json);



                //$caracterCodificado = '&#x00e9;'; // o '&#233;' también funcionaría
                //$json = html_entity_decode($json, ENT_COMPAT | ENT_HTML5, 'UTF-8');
//dd($json);

                $feedback = json_decode($json, true);

                $new->language_id = $feedback['language'];
                if (filter_var($feedback['recordingUrl'], FILTER_VALIDATE_URL)) {
                    $new->recording_url = $feedback['recordingUrl'];
                }
                else{
                    dump('no url: '.$feedback['recordingUrl']);
                }


                $new->observations = $feedback['finalComment'] ?? '';

                $new->feedbacks = $feedback['feedbacks'];

                $new->save();
            }
            catch (\Throwable $exception){

                dd($exception, $old, $feedback, $old->feedback_json, $json, json_last_error(), json_last_error_msg(), $old->id_feed_coach);

            }
        }
    }

}
