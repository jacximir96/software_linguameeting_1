<?php

namespace Database\Seeders;

use App\Src\_Old\Model\Emails;
use App\Src\EmailDomain\Email\Model\Email;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $olds = Emails::orderBy('id_email','asc')->get();

        foreach ($olds as $old){

            $user = User::find($old->id_user_receiver);

            //todo remove this check
            if (is_null($user)){
                continue;
            }

            $new = new Email();
            $new->id = $old->id_email;
            $new->receiver_id = $old->id_user_receiver;
            $new->email = $old->email_receiver;
            $new->subject = $old->subject_mail;
            $new->body = $old->body_mail;
            $new->send_at = $old->date_send_mes ? Carbon::parse($old->date_send_mes, 'Europe/Madrid')->setTimezone('UTC') : null;
            $new->type_message = $old->type_message;

            $new->save();
        }
    }
}
