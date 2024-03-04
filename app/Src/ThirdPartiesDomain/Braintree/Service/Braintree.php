<?php

namespace App\Src\ThirdPartiesDomain\Braintree\Service;

use Braintree\Gateway;

class Braintree
{
    private Gateway $gateway;

    public function __construct()
    {
        $this->gateway = new Gateway([
            'environment' => config('braintree.config.environment'),
            'merchantId' => config('braintree.config.merchant_id'),
            'publicKey' => config('braintree.config.public_key'),
            'privateKey' => config('braintree.config.private_key'),
        ]);

    }

    public function createToken()
    {
        $clientToken = $this->gateway->clientToken()->generate();

        return $clientToken;
    }

    public function transactionSale(TransactionSaleDto $dto): TransactionResponse
    {
        $result = $this->gateway->transaction()->sale([
            'amount' => $dto->getAmount(),
            'paymentMethodNonce' => $dto->getNonce(),
            'customer' => [
                'firstName' => $dto->getFirstName(),
                'lastName' => $dto->getLastName(),
            ],
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);

        if ($result->success == 1) {
            $response = [
                'result' => $result->transaction,
                'success' => 1,
            ];
        } else {
            $response = [
                'errors' => $result->errors->deepAll(),
                'success' => 0,
            ];
        }

        return new TransactionResponse($response);
    }

    public function transactioRefund(TransactionRefundDto $refundDto): TransactionResponse
    {

        $result = $this->gateway->transaction()->refund($refundDto->transactionId()->get());

        if ($result->success == 1) {
            $response = [
                'result' => $result->transaction,
                'success' => 1,
            ];
        } else {
            $response = [
                'errors' => $result->errors->deepAll(),
                'success' => 0,
            ];
        }

        return new TransactionResponse($response);
    }
}
