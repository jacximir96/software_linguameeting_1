<?php
namespace App\Http\Controllers\Admin\Coach\Billing\ForAll\File;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\SalaryDomain\Billing\Export\BatchPaymentExport;
use App\Src\CoachDomain\SalaryDomain\Billing\Export\BatchPaypalPaymentExport;
use App\Src\CoachDomain\SalaryDomain\Billing\Export\BillingExport;
use App\Src\CoachDomain\SalaryDomain\Billing\Presenter\SearchBillingPresenter;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\TimeDomain\Month\Service\Month;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


class DownloadPaypalBatchPaymentController extends Controller
{
    public function __invoke(int $month, int $year)
    {

        $month = new Month($month, $year);

        $presenter = app(SearchBillingPresenter::class);
        $viewData = $presenter->handle($month);
;
        $linguaMoney = new LinguaMoney();

        $now = Carbon::now();
        $filename = 'reports_coach_paypal_batch_payment_'.$now->format('Y-m-d_H_i_s');

        return Excel::download(new BatchPaypalPaymentExport($viewData, $linguaMoney), $filename.'.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
