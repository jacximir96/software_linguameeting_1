<?php

namespace Database\Seeders;

use App\Src\_Old\Model\ZoomMeetings;
use App\Src\_Old\Model\ZoomRecordings;
use App\Src\_Old\Model\ZoomUsers;
use App\Src\UserDomain\User\Model\User;
use App\Src\ZoomDomain\ZoomMeeting\Model\ZoomMeeting;
use App\Src\ZoomDomain\ZoomRecording\Model\ZoomRecording;
use App\Src\ZoomDomain\ZoomUser\Model\ZoomUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportZoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        $this->importZoomMeetings();

        $this->importZoomUsers();

        $this->importZoomRecordings();

        DB::commit();
    }

    private function importZoomMeetings()
    {

        $olds = ZoomMeetings::orderBy('id_user', 'asc')->get();

        foreach ($olds as $old) {

            $user = User::find($old->id_user);

            //todo remove this check
            if (is_null($user)) {
                continue;
            }

            $new = new ZoomMeeting();
            $new->id = $old->id_zoom_meeting;
            $new->user_id = $old->id_user;
            $new->zoom_id = $old->zoom_id;
            $new->uuid = $old->uuid;
            $new->start_url = $old->start_url;
            $new->join_url = $old->join_url;
            $new->is_active = $old->active_meeting;

            $new->save();
        }
    }

    private function importZoomUsers()
    {

        $olds = ZoomUsers::orderBy('id_user', 'asc')->get();

        foreach ($olds as $old) {

            $user = User::find($old->id_user);

            //todo remove this check
            if (is_null($user)) {
                continue;
            }

            $new = new ZoomUser();
            $new->user_id = $old->id_user;
            $new->host_id = $old->host_id;
            $new->user_zoom_id = $old->id_user_zoom;
            $new->zoom_email = $old->zoom_mail;
            $new->pmi = $old->pmi;

            $new->save();
        }
    }

    private function importZoomRecordings()
    {

        //todo remove take
        $olds = ZoomRecordings::orderBy('id_recording', 'desc')->take(2000)->get();

        foreach ($olds as $old) {

            $zoomUser = ZoomUser::where('host_id', $old->host_id)->first();

            if ( ! $zoomUser) {
                continue;
            }

            $new = new ZoomRecording();
            $new->id = $old->id_recording;
            $new->zoom_user_id = $zoomUser->id;
            $new->uuid = $old->uuid;
            //$new->account_id = $old->account_id ;
            $new->recording_zoom_id = $old->id_recording_zoom;
            //$new->host_id = $old->host_id ;
            $new->start = $old->recording_start;
            $new->end = $old->recording_end;
            $new->timezone = $old->timezone;
            $new->file_type = $old->file_type;
            $new->play_url = $old->play_url;
            $new->download_url = $old->download_url;
            $new->chat_file = $old->chat_file;
            $new->status = $old->status;

            $new->save();
        }
    }
}
