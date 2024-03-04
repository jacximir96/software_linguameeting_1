<?php

namespace App\Src\ThirdPartiesDomain\Jira\Service;

class Jira
{
    private $endpoint = '';

    private $endpoint_user = '';

    private $username = '';

    private $token = '';

    private $encoded_string = '';

    public function __construct()
    {
        //$this->endpoint = "https://linguameeting.atlassian.net/rest/api/3/issue/";
        $this->endpoint = config('jira.config.endpoint');
        $this->endpoint_user = config('jira.config.user');
        $this->username = config('jira.config.username');
        $this->token = config('jira.config.token');
        $this->encoded_string = config('jira.config.encoded_string');
    }

    public function sendRequest(IssueDto $dto)
    {
        $endpoint_customers = 'https://linguameeting.atlassian.net/rest/servicedeskapi/servicedesk/1/customer/?query='.$dto->getEmail();

        $ch_customer = curl_init();

        curl_setopt($ch_customer, CURLOPT_URL, $endpoint_customers);
        curl_setopt($ch_customer, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_customer, CURLOPT_ENCODING, '');
        curl_setopt($ch_customer, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch_customer, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch_customer, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch_customer, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch_customer, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch_customer, CURLOPT_HTTPHEADER, [
            'Authorization: Basic '.$this->encoded_string,
            'Accept: application/json',
            'Content-Type: application/json',
            'X-ExperimentalApi: opt-in',
        ]);

        $response_customer = curl_exec($ch_customer);
        curl_close($ch_customer);

        $data_response_customer = json_decode($response_customer);

        if (! empty($data_response_customer->values)) {
            $account_id = $data_response_customer->values[0]->accountId;
        } else {

            $data_user_arr = [
                'email' => $dto->getEmail(),
                'displayName' => $dto->getName(),
            ];

            $data_user_send = json_encode($data_user_arr);

            $ch_user = curl_init();

            curl_setopt($ch_user, CURLOPT_URL, $this->endpoint_user);
            curl_setopt($ch_user, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_user, CURLOPT_ENCODING, '');
            curl_setopt($ch_user, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch_user, CURLOPT_TIMEOUT, 0);
            curl_setopt($ch_user, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch_user, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch_user, CURLOPT_CUSTOMREQUEST, 'POST');

            curl_setopt($ch_user, CURLOPT_POSTFIELDS, $data_user_send);
            curl_setopt($ch_user, CURLOPT_HTTPHEADER, [
                'Authorization: Basic '.$this->encoded_string,
                'Accept: application/json',
                'Content-Type: application/json',
                'X-ExperimentalApi: opt-in',
            ]);

            $response_user = curl_exec($ch_user);
            curl_close($ch_user);

            $data_response = json_decode($response_user);

            $account_id = $data_response->accountId;
        }

        $data_send_arr = [
            'serviceDeskId' => 1,
            'requestTypeId' => $dto->getIssueType()->name,
            'raiseOnBehalfOf' => $account_id,
            'requestFieldValues' => [
                'summary' => $dto->getSummary(),
                'description' => $dto->descriptionExtend(),
            ],
        ];

        $data_send = json_encode($data_send_arr);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_send);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic '.$this->encoded_string,
            'Accept: application/json',
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }
}
