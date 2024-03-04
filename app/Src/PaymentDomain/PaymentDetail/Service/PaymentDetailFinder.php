<?php
namespace App\Src\PaymentDomain\PaymentDetail\Service;

use App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;


class PaymentDetailFinder
{

    public function findPaymentDetailByEnrollment (Enrollment $enrollment):?PaymentDetail
    {

        $isOrigin = false;

        do {
            //este bucle se asegura que buscamos el detalle del pago de una matrícula en el caso de que la matrícula tenga un origen distinto a ella misma como puede ser en el
            //cambio de curso de un estudiante.

            if ($enrollment->enrollmentOrigin) {
                $enrollment = $enrollment->enrollmentOrigin;
            } else {
                $isOrigin = true;
            }

        } while ( ! $isOrigin);

        return $enrollment->paymentDetail;
    }
}
