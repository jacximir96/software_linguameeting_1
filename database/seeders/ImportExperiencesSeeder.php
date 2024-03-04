<?php

namespace Database\Seeders;

use App\Src\_Old\Model\Experiences;
use App\Src\_Old\Model\ExperiencesComments;
use App\Src\_Old\Model\ExperiencesDonations;
use App\Src\_Old\Model\ExperiencesUsers;
use App\Src\_Old\Model\ExperiencesUsersPublic;
use App\Src\ExperienceDomain\CodeOfferType\Model\CodeOfferType;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceComment\Model\ExperienceComment;
use App\Src\ExperienceDomain\ExperienceDonation\Model\ExperienceDonation;
use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFile;
use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFileType;
use App\Src\ExperienceDomain\ExperienceState\Model\ExperienceState;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Model\ExperienceRegisterPublic;
use App\Src\File\Service\PathBuilder;
use App\Src\PaymentDomain\MethodPayment\Model\MethodPayment;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportExperiencesSeeder extends Seeder
{
    use TraitImport;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        $this->generateCodeOfferType();

        $this->generateFileType();

        $this->importExperiences();

        DB::commit();
    }

    private function generateCodeOfferType (){

        $code = new CodeOfferType();
        $code->id = 1;
        $code->name='LinguaMeeting';
        $code->save();

        $code = new CodeOfferType();
        $code->id = 2;
        $code->name='LinguaMeetingMateLand';
        $code->save();

        $code = new CodeOfferType();
        $code->id = 3;
        $code->name='Experiences';
        $code->save();
    }

    private function generateFileType (){

        $type = new ExperienceFileType();
        $type->id =1;
        $type->name = 'Vocabulary';
        $type->save();


        $type = new ExperienceFileType();
        $type->id = 2;
        $type->name = 'Banner';
        $type->save();

    }

    private function importExperiences (){

        $linguaMoney = new LinguaMoney();

        $olds = Experiences::orderBy('id_experience')->get();

        foreach ($olds as $old){

            $user = User::find($old->coach_id);

            if (is_null($user)){
                continue;
            }

            $new = new Experience();
            $new->id = $old->id_experience;
            $new->coach_id = $old->coach_id;
            $new->coach_name = $old->name_coach;
            $new->coach_lastname = $old->lastname_coach;
            $new->language_id = $old->id_language;
            $new->level_id = $old->level_id;

            $new->code_offer_type_id = null;
            if (!empty($old->code_offer)){
                $codeOffer = $this->obtainCodeOffer($old->code_offer);
                $new->code_offer_type_id = $codeOffer->id;
            }

            $new->title = $old->title;
            $new->description = $old->description;

            $start = Carbon::parse($old->day.' '.$old->hour, 'America/New_York')->setTimezone('UTC');
            $end = Carbon::parse($old->day.' '.$old->hour_end, 'America/New_York')->setTimezone('UTC');
            $new->start = $start;
            $new->end = $end;

            $new->url_join = $old->url_join;
            $new->url_host = $old->url_host;

            $new->is_public = $old->public;
            $new->is_paid_public = $old->pay_public;
            $new->is_donate_public = $old->donate_public;
            $new->is_private = $old->private;
            $new->is_paid_private = $old->pay_private;
            $new->is_donate_private = $old->donate_private;

            $new->max_students = $old->num_max_students;

            $price = $linguaMoney->buildFromFloat($old->price);
            $new->price = $price;

            $new->zoom_video = $old->zoom_video;
            $new->meeting_id = $old->meeting_id;
            $new->save();

            if (is_string ($old->banner1) AND !empty($old->banner1)){
                $this->processFile($old, 'banner1', 2, 1);
            }
            if (is_string ($old->banner2) AND !empty($old->banner2)){
                $this->processFile($old, 'banner2', 2, 2);
            }
            if (is_string ($old->vocabulary) AND !empty($old->vocabulary)){
                $this->processFile($old, 'vocabulary', 1, 1);
            }

            $this->processComment($new);

            //$this->processDonation($new);

            //$this->processUser($new);

            //$this->processUserPublic($new);
        }
    }

    private function obtainCodeOffer (string $offer){

        return CodeOfferType::where('name', $offer)->first();

    }

    private function processFile (Experiences $old, string $field, int $fileTypeId, int $order){

        $pathBuilder = new PathBuilder();

        $path = $pathBuilder->buildPublicAbsolutePath(ExperienceFile::KEY_PATH);

        $oldFilename = basename($old->$field);

        if ($path->hasFile($oldFilename)) {
            //dd($oldFilename);
        }
        $file = new ExperienceFile();
        $file->experience_id = $old->id_experience;
        $file->experience_file_type_id = $fileTypeId;
        $file->filename = $oldFilename;
        $file->original_name = $oldFilename;
        $file->order = $order;

        $pathInfo = pathinfo($oldFilename);
        $file->mime = $this->obtainMime($pathInfo['extension']);
        $file->save();

    }

    private function processComment (Experience $experience){

        $olds = ExperiencesComments::where('experience_id', $experience->id)->get();

        foreach ($olds as $old){

            if ($old->user_id == 0){
                continue;
            }

            if ($old->user_id){

                $student = User::find($old->user_id);
                if (is_null($student)){
                    continue;
                }
            }

            $new = new ExperienceComment();
            $new->experience_id = $experience->id;
            $new->user_id = $old->user_id;
            $new->comment = $old->comment;
            $new->stars = $old->stars;
            $new->name = $old->name;
            $new->commented_at = Carbon::now();
            $new->lastname = $old->lastname;
            $new->email = $old->email;

            $new->save();
        }
    }

    private function processDonation (Experience $experience){

        $linguaMoney = new LinguaMoney();

        $olds = ExperiencesDonations::where('experience_id', $experience->id)->get();

        foreach ($olds as $old){

            if ($old->user_id == 0){
                continue;
            }

            if ($old->user_id){

                $student = User::find($old->user_id);
                if (is_null($student)){
                    continue;
                }
            }

            $new = new ExperienceDonation();
            $new->id = $old->id_donation;
            $new->experience_id = $old->experience_id;
            $new->user_id = $old->user_id;
            $new->name = $old->name_user;
            $new->lastname = $old->lastname_user;
            $new->email = $old->email_user;

            if ($old->type_payment == 'PAYPAL'){
                $new->method_payment_id = MethodPayment::ID_PAYPAL;
            }
            else{
                $new->method_payment_id = MethodPayment::ID_CREDIT_CARD;
            }

            $price = $linguaMoney->buildFromFloat($old->value);
            $new->price = $price;

            $new->payment_id = $old->payment_id;
            $new->payer_id = $old->payer_id;
            $new->experience_state_id = 1;
            $new->email_payment = $old->email_payment;
            $new->donation_at = $new->donation_at ? Carbon::parse($old->date_donation, 'Europe/Madrid')->setTimezone('UTC') : null;
            $new->paid = $old->paid;

            $new->save();
        }
    }

    private function processUser (Experience $experience){

        $linguaMoney = new LinguaMoney();

        $olds = ExperiencesUsers::where('experience_id', $experience->id)->get();

        foreach ($olds as $old){

            if ($old->user_id == 0){
                continue;
            }

            if ($old->user_id){

                $student = User::find($old->user_id);
                if (is_null($student)){
                    continue;
                }
            }

            $new = new ExperienceRegister();
            $new->experience_id = $old->experience_id;
            $new->user_id = $old->user_id;

            $new->registered_at = $old->date_register ? Carbon::parse($old->date_register, 'Europe/Madrid')->setTimezone('UTC') : null;
            $new->attendance = $old->attendance;

            $price = $linguaMoney->buildFromFloat($old->value);
            $new->price = $price;

            if ($old->type_payment == 'PAYPAL'){
                $new->method_payment_id = MethodPayment::ID_PAYPAL;
            }
            elseif ($old->type_payment == 'CODE'){
                $new->method_payment_id = MethodPayment::ID_CODE;
            }
            elseif ($old->type_payment == 'FREE'){
                $new->method_payment_id = MethodPayment::ID_FREE;
            }
            else{
                $new->method_payment_id = MethodPayment::ID_CREDIT_CARD;
            }


            $new->payment_id = $old->payment_id;
            $new->payer_id = $old->payer_id;
            $new->experience_state_id = 1;
            $new->email_payment = $old->email_payment;
            $new->payment_at = $old->date_payment ? Carbon::parse($old->date_payment, 'Europe/Madrd')->setTimezone('UTC') : null;
            if ($old->date_join){
                $new->joined_at = $old->date_join ? Carbon::parse($old->date_join, 'Europe/Madrid')->setTimezone('UTC') : null;
            }
            $new->paid = $old->paid;

            $new->save();
        }
    }

    private function processUserPublic (Experience $experience){

        $linguaMoney = new LinguaMoney();

        $olds = ExperiencesUsersPublic::where('experience_id', $experience->id)->get();

        foreach ($olds as $old){

            $new = new ExperienceRegisterPublic();
            $new->experience_id = $old->experience_id;
            $new->registered_at = $old->date_register ? Carbon::parse($old->date_register, 'Europe/Madrid')->setTimezone('UTC') : null;

            $price = $linguaMoney->buildFromFloat($old->value);
            $new->price = $price;

            if ($old->type_payment == 'PAYPAL'){
                $new->method_payment_id = MethodPayment::ID_PAYPAL;
            }
            elseif ($old->type_payment == 'CODE'){
                $new->method_payment_id = MethodPayment::ID_CODE;
            }
            elseif ($old->type_payment == 'FREE'){
                $new->method_payment_id = MethodPayment::ID_FREE;
            }
            else{
                $new->method_payment_id = MethodPayment::ID_CREDIT_CARD;
            }

            $new->email = $old->email;
            $new->name = $old->name;
            $new->lastname = $old->lastname;
            $new->school = $old->school;

            $new->payment_id = $old->payment_id;
            $new->payer_id = $old->payer_id;
            $new->experience_state_id = 1;
            $new->email_payment = $old->email_payment;
            $new->payment_at = $old->date_payment ? Carbon::parse($old->date_payment, 'Europe/Madrid')->setTimezone('UTC') : null;
            $new->paid = $old->paid;

            $new->save();
        }
    }
}
