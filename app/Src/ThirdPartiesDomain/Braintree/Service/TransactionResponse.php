<?php

namespace App\Src\ThirdPartiesDomain\Braintree\Service;

use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Illuminate\Support\Collection;
use Money\Money;

class TransactionResponse
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function transactionId(): string
    {

        if (isset($this->data['result'])) {
            return $this->data['result']->id;
        }

        return '';
    }

    public function transactionIsSuccess(): bool
    {

        if ($this->isSuccess()) {
            return $this->isAuthorized() or $this->isSubmittedForSettlement();
        }

        return false;
    }

    public function amount(): Money
    {

        if (! isset($this->data['result']->amount)) {
            throw new \InvalidArgumentException('Amount not exists in Braintree Response');
        }

        if (! isset($this->data['result']->currencyIsoCode)) {
            throw new \InvalidArgumentException('CurrencyIsoCode not exists in Braintree Response');
        }

        $linguaMoney = new LinguaMoney();

        return $linguaMoney->buildFromFloat($this->data['result']->amount, $this->data['result']->currencyIsoCode);

    }

    public function errors(): Collection
    {

        $errors = collect();

        if (isset($this->data['errors'])) {

            foreach ($this->data['errors'] as $error) {
                $error = new ErrorMessage($error->attribute, $error->code, $error->message);
                $errors->push($error);
            }
        }

        return $errors;
    }

    public function transactionHasBeenRefunded(): bool
    {

        if (isset($this->data['errors'])) {

            foreach ($this->data['errors'] as $error) {
                if ($error->code == 91512) {
                    return true;
                }
            }
        }

        return false;
    }

    public function errorsToJson(): string
    {

        $errors = [];
        foreach ($this->errors() as $error) {
            $errors[] = $error->toArray();
        }

        return json_encode($errors);
    }

    private function isSuccess(): bool
    {
        return (bool) $this->data['success'];
    }

    private function isAuthorized(): bool
    {
        return $this->status() == 'authorized';
    }

    private function isSubmittedForSettlement(): bool
    {
        return $this->status() == 'submitted_for_settlement';
    }

    private function status(): string
    {
        return $this->data['result']->status;
    }
}

/*

App\Src\ThirdPartiesDomain\Braintree\Service\TransactionSaleResponse {#879 ▼ // app/Src/StudentDomain/Student/Action/Register/CreditCardStudentRegisterAction.php:108
  -data: array:2 [▼
    "result" => Braintree\Transaction {#876 ▼
      #_attributes: array:97 [▼
        "id" => "mh64gf1r"
        "status" => "submitted_for_settlement"
        "type" => "sale"
        "currencyIsoCode" => "EUR"
        "amount" => "40.00"
        "amountRequested" => "40.00"
        "merchantAccountId" => "linguameeting"
        "subMerchantAccountId" => null
        "masterMerchantAccountId" => null
        "orderId" => null
        "createdAt" => DateTime @1692854788 {#828 ▶}
        "updatedAt" => DateTime @1692854789 {#837 ▶}
        "customer" => array:8 [▶]
        "billing" => array:13 [▶]
        "refundId" => null
        "refundIds" => []
        "refundedTransactionId" => null
        "partialSettlementTransactionIds" => []
        "authorizedTransactionId" => null
        "settlementBatchId" => null
        "shipping" => array:13 [▶]
        "customFields" => null
        "accountFundingTransaction" => false
        "avsErrorResponseCode" => null
        "avsPostalCodeResponseCode" => "I"
        "avsStreetAddressResponseCode" => "I"
        "cvvResponseCode" => "I"
        "gatewayRejectionReason" => null
        "processorAuthorizationCode" => "DMN763"
        "processorResponseCode" => "1000"
        "processorResponseText" => "Approved"
        "additionalProcessorResponse" => null
        "voiceReferralNumber" => null
        "purchaseOrderNumber" => null
        "taxAmount" => null
        "taxExempt" => false
        "scaExemptionRequested" => null
        "processedWithNetworkToken" => false
        "creditCard" => array:24 [▶]
        "statusHistory" => array:2 [▶]
        "planId" => null
        "subscriptionId" => null
        "subscription" => array:2 [▶]
        "addOns" => []
        "discounts" => []
        "descriptor" => Braintree\Descriptor {#878 ▶}
        "recurring" => false
        "channel" => null
        "serviceFeeAmount" => null
        "escrowStatus" => null
        "disbursementDetails" => Braintree\DisbursementDetails {#853 ▶}
        "disputes" => []
        "achReturnResponses" => []
        "authorizationAdjustments" => []
        "paymentInstrumentType" => "credit_card"
        "processorSettlementResponseCode" => null
        "processorSettlementResponseText" => null
        "networkResponseCode" => null
        "networkResponseText" => null
        "merchantAdviceCode" => null
        "merchantAdviceCodeText" => null
        "threeDSecureInfo" => null
        "shipsFromPostalCode" => null
        "shippingAmount" => null
        "discountAmount" => null
        "networkTransactionId" => "020230824052629"
        "processorResponseType" => "approved"
        "authorizationExpiresAt" => DateTime @1693718789 {#787 ▶}
        "retryIds" => []
        "retriedTransactionId" => null
        "refundGlobalIds" => []
        "partialSettlementTransactionGlobalIds" => []
        "refundedTransactionGlobalId" => null
        "authorizedTransactionGlobalId" => null
        "globalId" => "dHJhbnNhY3Rpb25fbWg2NGdmMXI"
        "retryGlobalIds" => []
        "retriedTransactionGlobalId" => null
        "retrievalReferenceNumber" => "1234567"
        "achReturnCode" => null
        "installmentCount" => null
        "installments" => []
        "refundedInstallments" => []
        "responseEmvData" => null
        "acquirerReferenceNumber" => null
        "merchantIdentificationNumber" => null
        "terminalIdentificationNumber" => null
        "merchantName" => null
        "merchantAddress" => array:5 [▶]
        "pinVerified" => false
        "debitNetwork" => null
        "processingMode" => null
        "paymentReceipt" => array:18 [▶]
        "creditCardDetails" => Braintree\Transaction\CreditCardDetails {#775 ▶}
        "customerDetails" => Braintree\Transaction\CustomerDetails {#866 ▶}
        "billingDetails" => Braintree\Transaction\AddressDetails {#883 ▶}
        "shippingDetails" => Braintree\Transaction\AddressDetails {#851 ▶}
        "subscriptionDetails" => Braintree\Transaction\SubscriptionDetails {#863 ▶}
      ]
    }
    "success" => 1
  ]
}


 */
