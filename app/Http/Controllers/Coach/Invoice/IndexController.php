<?php
namespace App\Http\Controllers\Coach\Invoice;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Presenter\Breadcrumb\Coach\IndexBreadcrumb;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\CoachSearchForm;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Repository\CoachReviewOptionRepository;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Presenter\Breadcrumb\CoachInvoicesBreadcrumb;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Repository\InvoiceRepository;
use App\Src\Shared\Service\CriteriaSearch;


class IndexController extends Controller
{
    use Breadcrumable;

    /**
     * @var InvoiceRepository
     */
    private InvoiceRepository $invoiceRepository;

    public function __construct (InvoiceRepository $invoiceRepository){

        $this->invoiceRepository = $invoiceRepository;
    }

    public function __invoke()
    {
        $coach = user();

        $invoices = $this->invoiceRepository->obtainByCoach($coach);

        $breadcrumb = new CoachInvoicesBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coach' => $coach,
            'invoices' => $invoices,
        ]);

        return view('coach.billing.invoice.index');
    }
}
