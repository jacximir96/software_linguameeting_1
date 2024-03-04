<?php
namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\PaymentDomain\Payment\Presenter\Breadcrumb\Admin\IndexBreadcrumb;
use App\Src\PaymentDomain\Payment\Repository\PaymentRepository;


class IndexController extends Controller
{
    use Breadcrumable;


    private PaymentRepository $paymentRepository;

    public function __construct (PaymentRepository $paymentRepository){

        $this->paymentRepository = $paymentRepository;
    }

    public function __invoke()
    {

        $payments = $this->paymentRepository->allPaginate();

        $breadcrumb = new IndexBreadcrumb();

        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'payments' => $payments,
            'timezone' => $this->userTimezone(),
        ]);

        return view('admin.payment.index');
    }
}
