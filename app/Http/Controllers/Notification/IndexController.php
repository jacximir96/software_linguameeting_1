<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\NotificationDomain\Notification\Presenter\Printer\PrinterBuilder;
use App\Src\NotificationDomain\Notification\Repository\NotificationRepository;
use App\Src\NotificationDomain\Notification\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\NotificationDomain\Notification\Service\SearchForm;
use App\Src\Shared\Service\CriteriaSearch;


class IndexController extends Controller
{
    use Breadcrumable;


    private NotificationRepository $notificationRepository;

    public function __construct (NotificationRepository $notificationRepository){

        $this->notificationRepository = $notificationRepository;
    }


    public function __invoke()
    {

        $searchForm = app(SearchForm::class);
        $searchForm->config();;

        $filter = array_merge($searchForm->filterByUser(user()), ['read_status' => config('linguameeting.notification.status_read.no.key')]);
        $criteria = new CriteriaSearch($filter);

        $notifications = $this->notificationRepository->search($criteria);

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $printerBuilder = app(PrinterBuilder::class);

        view()->share([
            'loadExpanderJs' => true,
            'notifications' => $notifications,
            'printerBuilder' => $printerBuilder,
            'searchForm' => $searchForm,
            'user' => user(),
            'timezone' => $this->userTimezone(),
        ]);

        return view('notification.index');
    }
}
