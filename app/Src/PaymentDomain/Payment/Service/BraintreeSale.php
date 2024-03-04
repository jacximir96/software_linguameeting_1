<?php

namespace App\Src\PaymentDomain\Payment\Service;

use App\Src\ThirdPartiesDomain\Braintree\Exception\TransactionSaleException;
use App\Src\ThirdPartiesDomain\Braintree\Service\Braintree;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionResponse;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionSaleDto;
use Illuminate\Support\Facades\Log;

class BraintreeSale
{
    private Braintree $braintree;

    public function __construct(Braintree $braintree)
    {
        $this->braintree = $braintree;
    }

    public function runSale(TransactionSaleDto $infoSale, TransactionContext $context): TransactionResponse
    {

        $response = $this->braintree->transactionSale($infoSale);

        if ($response->transactionIsSuccess()) {
            return $response;
        }

        $errors = $response->errorsToJson();

        Log::channel('credit_card')
            ->error([
                'context' => $context->getContext(),
                'errors' => $errors,
            ]);

        $transactionException = new TransactionSaleException();
        $transactionException->setResponse($response);

        throw $transactionException;
    }
}
