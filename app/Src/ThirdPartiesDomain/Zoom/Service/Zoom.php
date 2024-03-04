<?php

namespace App\Src\ThirdPartiesDomain\Zoom\Service;

class Zoom
{
    private $endpoint = '';

    private $api_key = '';

    private $secret_key = '';

    public function __construct()
    {

        $this->endpoint = 'https://api.zoom.us/v2/';

        if (_ENVIRONMENT == 'production') {
            $this->api_key = 'dS6FtLMUReyuVmCTMFJZig'; // elena
            $this->secret_key = 'Ga6fmLfKrPf6LpTbmZdmuhldjYOn1sIo52eV'; // elena
        } else {
            //$this->api_key = "E2zr5JEiQi6JbK93qNLATw"; // sandra
            //$this->secret_key = "U1K8jVOmTQhMqcwMPSkg3yZo7SGxHcyHvmB7"; //sandra
            $this->api_key = 'dS6FtLMUReyuVmCTMFJZig'; // elena
            $this->secret_key = 'Ga6fmLfKrPf6LpTbmZdmuhldjYOn1sIo52eV'; // elena
        }

    }

    private function generateJWT()
    {
        //Zoom API credentials from https://developer.zoom.us/me/
        $token = [
            'iss' => $this->api_key,
            // The benefit of JWT is expiry tokens, we'll set this one to expire in 1 minute
            'exp' => time() + 60,
        ];

        return JWT::encode($token, $this->secret_key);

    }

    private function sendRequest($request, $data = '', $type = '')
    {

        $response = '';
        $data_send = json_encode($data);
        $url = $this->endpoint.$request;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if (empty($data)) { // --- For GET request

            if ($type == 'DELETE') {

                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            }

            // --- default is GET option
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer '.$this->generateJWT(),
            ]);

        } else { // --- For POST request

            if ($type == 'PUT') {

                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

            } elseif ($type == 'PATCH') {

                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            } else {
                curl_setopt($ch, CURLOPT_POST, true);
            }

            curl_setopt($ch, CURLOPT_HTTPGET, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_send);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer '.$this->generateJWT(),
                'Content-Type: application/json',
                'Content-Length: '.strlen($data_send),
            ]);

        }

        $response = curl_exec($ch);
        curl_close($ch);

        //var_dump($response);
        return json_decode($response);

    }

    public function getUsers()
    {

        $request = 'users';

        return $this->sendRequest($request);

    }

    /**
     * Create new zoom account with an email. The $info is an object with:
     * - Email
     * - First name
     * - Last name
     *
     * @param  object  $info
     * @return \stdClass
     */
    public function createUser($info, $password)
    {

        //$password = generarCodigo(8);
        $request = 'users';

        $data = new stdClass();
        $data->action = 'create';
        $data->user_info = new stdClass();
        $data->user_info->email = $info->email;
        $data->user_info->type = 1;
        $data->user_info->first_name = $info->first_name;
        $data->user_info->last_name = $info->last_name;
        $data->user_info->password = $password;

        if (! empty($data)) {
            return $this->sendRequest($request, $data);
        } else {
            $error = new stdClass();
            $error->code = 001;
            $error->message = 'No data for create zoom user';

            return $error;
        }

    }

    /**
     * Retriever an existing zoom user. The $info can be the id zoom user or the email zoom user
     *
     * @param  string  $info
     * @return type
     */
    public function retrieveUser($info)
    {

        $request = 'users/'.$info;

        return $this->sendRequest($request);

    }

    public function updateUser($info, $id_mail)
    {

        $request = 'users/'.$id_mail;

        $data = $info;

        if (! empty($data)) {
            return $this->sendRequest($request, $data, 'PATCH');
        } else {
            $error = new stdClass();
            $error->code = 002;
            $error->message = 'No data for update zoom user';

            return $error;
        }
    }

    public function deleteUser($info)
    {

        $request = 'users/'.$info;

        return $this->sendRequest($request, '', 'DELETE');

    }

    public function retrieveUserSettings($info)
    {

        $request = 'users/'.$info.'/settings';

        return $this->sendRequest($request);

    }

    /**
     * Update the zoom user password.
     *
     * @param  object  $info -> object with the password $info->password = password.
     * @param  type  $id_mail
     * @return \stdClass
     */
    public function updateUserPassword($info, $id_mail)
    {

        $request = 'users/'.$id_mail.'/password';

        $data = $info;

        if (! empty($data)) {
            return $this->sendRequest($request, $data, 'PUT');
        } else {
            $error = new stdClass();
            $error->code = 003;
            $error->message = 'No data for update zoom user password';

            return $error;
        }

    }

    /**
     * Get meetings for a user. The $info can be the id zoom user or the email zoom user.
     *
     * @param  string  $info
     * @return type
     */
    public function getMeetings($info)
    {

        $request = 'users/'.$info.'/meetings';

        return $this->sendRequest($request);

    }

    public function createMeeting($info, $id_mail)
    {

        $request = 'users/'.$id_mail.'/meetings';

        $data = new stdClass();
        $data->topic = $info->first_name.' '.$info->last_name;
        $data->type = 3;
        $data->password = '12345Jh8@';
        $data->settings = new stdClass();
        $data->settings->waiting_room = 0;
        $data->settings->meeting_authentication = 0;

        return $this->sendRequest($request, $data);

    }

    public function createMeetingScheduled($info, $id_mail)
    {

        $request = 'users/'.$id_mail.'/meetings';

        $data = new stdClass();
        $data->topic = $info->topic;
        $data->type = 2;
        $data->start_time = $info->start_time;
        $data->timezone = $info->timezone;
        $data->duration = $info->duration; //minutes
        $data->password = '12345Jh8@';
        $data->settings = new stdClass();
        $data->settings->waiting_room = 0;
        $data->settings->meeting_authentication = 0;

        return $this->sendRequest($request, $data);

    }

    public function retrieveMeeting($id)
    {

        $request = 'meetings/'.$id;

        return $this->sendRequest($request);

    }

    public function updateMeeting($info, $id)
    {

        $request = 'meetings/'.$id;

        $data = $info;

        if (! empty($data)) {
            return $this->sendRequest($request, $data, 'PATCH');
        } else {
            $error = new stdClass();
            $error->code = 004;
            $error->message = 'No data for update meeting';

            return $error;
        }

    }

    public function deleteMeeting($id)
    {

        $request = 'meetings/'.$id;

        return $this->sendRequest($request, '', 'DELETE');

    }

    // only for paid users
    public function addMeetingRegistrant($info, $id)
    {

        $request = 'meetings/'.$id.'/registrants';

        $data = new stdClass();
        $data->email = $info->email;
        $data->first_name = $info->first_name;
        $data->last_name = $info->last_name;
        $data->country = $info->country;
        $data->job_title = 'Student';
        $data->comments = 'Student for linguameeting';

        return $this->sendRequest($request, $data);

    }

    // --- The documentation says uuid, bur is the normal id
    public function retrieveMeetingDetails($uuid)
    {

        $request = 'past_meetings/'.$uuid;

        return $this->sendRequest($request);

    }

    // --- The documentation says uuid, bur is the normal id
    public function retrievePastMeetingPart($uuid)
    {

        $request = 'past_meetings/'.$uuid.'/participants';

        return $this->sendRequest($request);

    }

    public function retrieveHostReport($date_ini, $date_end)
    {

        $request = 'report/users?type=active&from='.$date_ini.'&to='.$date_end;

        return $this->sendRequest($request);

    }

    public function retrieveMeetingsReport($info)
    {

        $request = 'report/users/'.$info->id.'/meetings?from='.$info->date_ini.'&to='.$info->date_end;

        return $this->sendRequest($request);
    }

    public function retrieveMeetingsDetailsReport($id)
    {

        $request = 'report/meetings/'.$id;

        return $this->sendRequest($request);
    }

    public function retrieveMeetingsPartReport($id)
    {

        $request = 'report/meetings/'.$id.'/participants';

        return $this->sendRequest($request);

    }

    public function retrieveMeetingsPollsReport($id)
    {

        $request = 'report/meetings/'.$id.'/polls';

        return $this->sendRequest($request);

    }

    public function switchWebhookVersion($version)
    {

        $request = 'webhooks/options';

        $data = new stdClass();
        $data->version = $version;

        return $this->sendRequest($request, $data, 'PATCH');

    }

    public function getWebhooks()
    {

        $request = 'webhooks';

        return $this->sendRequest($request);

    }

    public function createWebhook($info)
    {

        $request = 'webhooks';

        $data = $info;

        if (! empty($data)) {
            return $this->sendRequest($request, $data);
        } else {
            $error = new stdClass();
            $error->code = 005;
            $error->message = 'No data for create webhook';

            return $error;
        }

    }

    public function retrieveWebhook($id)
    {

        $request = 'webhooks/'.$id;

        return $this->sendRequest($request);

    }

    public function updateWebhook($info, $id)
    {

        $request = 'webhooks/'.$id;

        $data = $info;

        if (! empty($data)) {
            return $this->sendRequest($request, $data, 'PATCH');
        } else {
            $error = new stdClass();
            $error->code = 006;
            $error->message = 'No data for update webhook';

            return $error;
        }

    }

    public function deleteWebhook($id)
    {

        $request = 'webhooks/'.$id;

        return $this->sendRequest($request, '', 'DELETE');

    }

    /**
     * Get all recording for a user.
     *
     * @param  object  $info
     * @param  string  $id_mail -> user id
     * @return type
     */
    public function getAllRecordings($info, $id_mail)
    {

        $request = '';
        if (! empty($info)) {
            $request = 'users/'.$id_mail.'/recordings?from='.$info->date_ini.'&to='.$info->date_end;
        } else {
            $request = 'users/'.$id_mail.'/recordings';
        }

        return $this->sendRequest($request);
    }

    public function getAllRecordingsWithout($id_mail)
    {

        $request = 'users/'.$id_mail.'/recordings';

        return $this->sendRequest($request);
    }

    //The meeting ID or meeting UUID. If given meeting ID, will take the last meeting instance.
    public function getAllMeetingsRecordings($id)
    {

        $request = 'meetings/'.$id.'/recordings';

        return $this->sendRequest($request);

    }

    public function recoverMeetingsRecording($id)
    {

        $request = 'meetings/'.$id.'/recordings/status';

        $data = new stdClass();
        $data->action = 'recover';

        return $this->sendRequest($request, $data, 'PUT');

    }

    public function recoverSingleRecording($id_meeting, $id_recording)
    {

        $request = 'meetings/'.$id_meeting.'/recordings/'.$id_recording.'/status';

        $data = new stdClass();
        $data->action = 'recover';

        return $this->sendRequest($request, $data, 'PUT');

    }
}
