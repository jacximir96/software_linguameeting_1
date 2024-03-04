<?php
namespace App\Http\Controllers\Student\Payment;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;

use App\Src\PaymentDomain\Payment\Repository\PaymentRepository;
use App\Src\PaymentDomain\Payment\Presenter\Breadcrumb\Student\IndexBreadcrumb;


class IndexController extends Controller
{
    use Breadcrumable;


    private PaymentRepository $paymentRepository;

    public function __construct (PaymentRepository $paymentRepository){

        $this->paymentRepository = $paymentRepository;
    }

    public function __invoke()
    {

        $student = user();
        $payments = $this->paymentRepository->obtainFromStudent($student);

        $timezone = $student->timezone;

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'payments' => $payments,
            'student' => $student,
            'timezone' => $timezone,
        ]);

        return view('student.payments.index');
    }
}
