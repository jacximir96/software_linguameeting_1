<?php
namespace App\Http\Controllers\Admin\Experience;

use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\PaymentDomain\PaymentDetail\Repository\PaymentDetailRepository;


class DonationsIndexController extends Controller
{

    private PaymentDetailRepository $paymentDetailRepository;

    public function __construct (PaymentDetailRepository $paymentDetailRepository){
        $this->paymentDetailRepository = $paymentDetailRepository;
    }

    public function __invoke(Experience $experience)
    {

        $paymentsDetails = $this->paymentDetailRepository->obtainDetail($experience);

        $linguaMoney = new LinguaMoney();

        view()->share([
            'experience' => $experience,
            'paymentsDetails' => $paymentsDetails,
            'linguaMoney' => $linguaMoney,
        ]);

        return view('admin.experience.donations_index');
    }
}
