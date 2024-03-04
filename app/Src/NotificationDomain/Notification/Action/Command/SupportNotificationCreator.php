<?php

namespace App\Src\NotificationDomain\Notification\Action\Command;

use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\NotificationDomain\Notification\Service\Message;
use App\Src\NotificationDomain\Notification\Service\Recipients;
use App\Src\NotificationDomain\NotificationType\Model\NotificationType;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionResponse;

class SupportNotificationCreator extends NotificationCreator
{
    public function createRefundErrorNotification(Payment $payment, TransactionResponse $transactionResponse, \Throwable $exception): Notification
    {

        $message = trans('notification.collection.tech_support.payment.error_refund', ['paymentId' => $payment->id]);

        $message = Message::buildWithException($message, $exception, $transactionResponse->errorsToJson());

        return $this->createNotification($message, $this->recipients(), NotificationType::REFUND_ERROR_ID);
    }

    public function createEnrollmentDeleteErrorNotification(Enrollment $enrollment, \Throwable $exception): Notification
    {

        $message = trans('notification.collection.tech_support.enrollment.deleting', ['enrollmentId' => $enrollment->id]);

        $message = Message::buildWithException($message, $exception);

        return $this->createNotification($message, $this->recipients(), NotificationType::REFUND_ERROR_ID);
    }

    private function recipients(): Recipients
    {

        $recipients = new Recipients();

        $recipients->add(config('linguameeting.user.ids.tech_support'));

        return $recipients;
    }
}
