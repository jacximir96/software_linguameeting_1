<?php

namespace Database\Seeders;

use App\Src\_Old\Model\UsersLanguages;
use App\Src\_Old\Model\ZoomMeetings;
use App\Src\_Old\Model\ZoomRecordings;
use App\Src\_Old\Model\ZoomUsers;
use App\Src\UserDomain\Language\Model\UserLanguage;
use App\Src\UserDomain\User\Model\User;
use App\Src\ZoomDomain\ZoomMeeting\Model\ZoomMeeting;
use App\Src\ZoomDomain\ZoomRecording\Model\ZoomRecording;
use App\Src\ZoomDomain\ZoomUser\Model\ZoomUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportInfoUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->importUserLanguage();
    }

    private function importUserLanguage (){

        $languages = \App\Src\Localization\Language\Model\Language::all();

        $users = User::all();

        foreach ($users as $user){

            $oldLanguages = UsersLanguages::where('id_user', $user->id)->get();

            if ($oldLanguages->count()){
                foreach ($oldLanguages as $oldLanguage){
                    $this->createLanguage($user->id, $oldLanguage->id_language);
                }
            }
            else{

                foreach ($languages as $language){
                    $this->createLanguage($user->id, $language->id);
                }
            }
        }
    }

    private function createLanguage (int $userId, int $languageId){

        $new = new UserLanguage();
        $new->user_id = $userId;
        $new->language_id = $languageId;
        $new->save();
    }


}
