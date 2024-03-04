<?php

namespace Database\Seeders;

use App\Src\_Old\Model\UsersKeys;
use App\Src\InstructorDomain\Canvas\Model\CanvasUserKey;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportUsersKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::beginTransaction();

        $keys = UsersKeys::all();

        foreach ($keys as $key){

            $user = User::find($key->id_user);

            if ($user){
                $new = new CanvasUserKey();
                $new->user_id = $user->id;
                $new->consumer_key = $key->consumer_key;
                $new->consumer_secret = $key->consumer_secret;
                $new->active = $key->active;

                $new->save();
            }
        }

        DB::commit();

    }
}
