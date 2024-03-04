<?php
namespace App\Http\Controllers\Admin\Coach\Billing\Invoice;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\InvoiceDomain\Invoice\Repository\InvoiceRepository;
use App\Src\UserDomain\User\Model\User;



class InvoiceCoachListController extends Controller
{

    private InvoiceRepository $invoiceRepository;

    public function __construct (InvoiceRepository $invoiceRepository){

        $this->invoiceRepository = $invoiceRepository;
    }

    public function __invoke(User $coach)
    {
        $invoices = $this->invoiceRepository->obtainByCoach ($coach);

        view()->share([
            'coach' => $coach,
            'invoices' => $invoices
        ]);

        return view('admin.coach.billing.invoice.coach_list');
    }
}
