<?php

namespace Database\Seeders;

use App\Src\_Old\Model\Users;
use App\Src\UserDomain\Role\Service\RoleChecker;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ImportUsersSeeder extends Seeder
{

    private ImportCoachAction $importCoachAction;

    private RoleChecker $roleChecker;

    public function run()
    {

        $this->importCoachAction = new ImportCoachAction();

        $this->roleChecker = new RoleChecker();

        DB::beginTransaction();


        $yo = Users::where('email', 'manuel@linguameeting.com')->first();
        $this->importUser($yo);

        $will = Users::where('email', 'will@linguameeting.com')->first();
        $this->importUser($will);

        $andrea = Users::where('email', 'andrea@linguameeting.com')->first();
        $this->importUser($andrea);

        $hannah = Users::where('email', 'hannah@linguameeting.com')->first();
        $this->importUser($hannah);

        $hansel = Users::where('email', 'hansel@linguameeting.com')->first();
        $this->importUser($hansel);


        /* with chunk for alll user
        Users::orderBy('id_user', 'asc')->take(300)->chunk(25, function ($itemsOld){

            foreach ($itemsOld as $itemOld){
                $this->import($itemOld);
            }
        });
        */

        $itemsOld = Users::orderBy('id_user', 'asc')->take(300)->get();
        $this->importUsers($itemsOld);

        $itemsOld = Users::orderBy('id_user', 'desc')->take(300)->get();
        $this->importUsers($itemsOld);

        //procesar cada uno de los importados
        $users = User::orderBy('id', 'asc')->get();
        foreach ($users as $user){

            $this->importCoachAction->associateCoordinatorCoach($user);

            $this->importCoachAction->associateSubstitutionCoach($user);

            $this->importCoachAction->createEvaluation($user);
        }

        DB::commit();
    }

    private function importUsers (Collection $itemsOld){

        foreach ($itemsOld as $itemOld){

            $exists = User::where('email', $itemOld->email)->first();

            if ($exists){
                dd($exists, 'continue');
                continue;
            }

            $this->importUser($itemOld);
        }

    }

    private function importUser (Users $itemOld){

        $user = new User();
        $user->id = $itemOld->id_user;
        $user->email = $itemOld->email;
        $user->password = $itemOld->password;

        $rol = Role::find($itemOld->rol);
        //echo "\r\n".$itemOld->rol;
        //echo " - ".$rol->name;
        $user->assignRole($rol);

        $user->active = $itemOld->active;
        $user->name = $itemOld->name_user;
        $user->lastname = $itemOld->lastname_user;
        $user->nickname = $itemOld->nickname;

        $user->timezone_id = $itemOld->id_zone;
        $user->country_id = $itemOld->id_country;
        if ( ! $itemOld->id_country_live){
            $user->country_live_id = null;
        }
        else{
            $user->country_live_id = $itemOld->id_country_live;
        }

        $user->url_photo = $itemOld->url_photo;

        $user->lingro_student = $itemOld->lingro_student;
        $user->phone = $itemOld->phone;
        $user->whatsapp = $itemOld->whatsapp;
        $user->skype = $itemOld->skype;

        $user->internal_comment = $itemOld->internal_comment;

        $user->created_at = $itemOld->created ? Carbon::parse($itemOld->created, 'Europe/Madrid')->setTimezone('UTC') : null;
        $user->updated_at = $itemOld->modified ? Carbon::parse($itemOld->modified, 'Europe/Madrid')->setTimezone('UTC') : null;
        if ($itemOld->erased){
            $user->deleted_at = Carbon::parse($itemOld->date_erased, 'Europe/Madrid')->setTimezone('UTC');
        }

        $user->email_reception = $itemOld->emailsReception;
        $user->email_marketing = $itemOld->emailsMarketing;

        $user->save();

        if ($user->hasRole('Coach')){
            $this->importCoachAction->handle($itemOld, $user);
        }
        elseif ($user->hasRole('Coach Coordinator')){
            $this->importCoachAction->handle($itemOld, $user);
        }
    }
}
