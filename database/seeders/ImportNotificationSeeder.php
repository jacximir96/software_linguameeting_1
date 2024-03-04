<?php

namespace Database\Seeders;

use App\Src\_Old\Model\Notifications;
use App\Src\_Old\Model\NotificationsLevel;
use App\Src\_Old\Model\NotificationsType;
use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\NotificationDomain\NotificationLevel\Model\NotificationLevel;
use App\Src\NotificationDomain\NotificationRecipient\Model\NotificationRecipient;
use App\Src\NotificationDomain\NotificationType\Model\NotificationType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();;

        $this->importLevel();

        $this->importType();

        $this->importNotifications();

        DB::commit();
    }

    private function importLevel (){

        $olds = NotificationsLevel::all();

        foreach ($olds as $old){

            $new = new NotificationLevel();
            $new->id = $old->id_level_notification;
            $new->name = $old->name_level_not;
            $new->color = $old->color();

            $new->save();
        }
    }

    private function importType (){

        $olds = NotificationsType::all();

        foreach ($olds as $old){

            $new = new NotificationType();
            $new->id = $old->id_type_notification;
            $new->notification_level_id = $old->id_level_notification;
            $new->name = $old->name_notification;
            $new->description = $old->description_notification;
            $new->save();

        }
    }

    private function importNotifications (){

        $olds = Notifications::whereIn('dest_user', [165, 198])->get();

        foreach ($olds as $old){

            $new = new Notification();
            $new->notification_type_id = $old->id_type_not;
            $new->content = $old->data;
            $new->notification_at = $old->date_insert ? Carbon::parse($old->date_insert, 'Europe/Madrid')->setTimezone('UTC') : null;

            $new->save();

            $recipient = new NotificationRecipient();
            $recipient->notification_id = $new->id;
            $recipient->user_id = $old->dest_user;
            $recipient->read_at = $old->date_read ? Carbon::parse($old->date_read, 'Europe/Madrid')->setTimezone('UTC') : null;
            $recipient->save();
        }
    }
}
