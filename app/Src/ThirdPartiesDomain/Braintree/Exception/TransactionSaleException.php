<?php

namespace App\Src\ThirdPartiesDomain\Braintree\Exception;

use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionResponse;

class TransactionSaleException extends \Exception
{
    private TransactionResponse $response;

    public function setResponse(TransactionResponse $response)
    {
        $this->response = $response;
    }
}
