<?php
namespace App\Http\Controllers\Notification;


use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\NotificationDomain\Notification\Presenter\Printer\PrinterBuilder;
use App\Src\NotificationDomain\Notification\Repository\NotificationRepository;
use App\Src\NotificationDomain\Notification\Request\SearchNotificationRequest;
use App\Src\NotificationDomain\Notification\Service\SearchForm;
use App\Src\NotificationDomain\NotificationRecipient\Action\MarkAllReadAction;
use App\Src\NotificationDomain\NotificationRecipient\Action\MarkAllUnreadAction;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\NotificationDomain\Notification\Presenter\Breadcrumb\IndexBreadcrumb;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class SearchController extends Controller
{
    use Breadcrumable;

    private NotificationRepository $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function __invoke(SearchNotificationRequest $request)
    {
        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $filter = array_merge($searchForm->filterByUser(user()), $searchForm->model());
        $criteria = new CriteriaSearch($filter);

        if ($request->markNotifications()) {
            $this->proccessNotifications($request, $criteria);
        }

        $notifications = $this->notificationRepository->search($criteria);

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $printerBuilder = app(PrinterBuilder::class);

        view()->share([
            'loadExpanderJs' => true,
            'notifications' => $notifications,
            'printerBuilder' => $printerBuilder,
            'searchForm' => $searchForm,
            'timezone' => $this->userTimezone(),
        ]);

        return view('notification.index');
    }

    private function proccessNotifications(SearchNotificationRequest $request, CriteriaSearch $criteria)
    {

        try {

            DB::beginTransaction();

            if ($request->markRead()){
                $action = app(MarkAllReadAction::class);
                $action->handle($criteria);

            }
            elseif($request->markUnread()){
                $action = app(MarkAllUnreadAction::class);
                $action->handle($criteria);
            }

            DB::commit();

            flash(trans('notification.notification.all.success'))->success();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update read status of notifications.', [
                'criteria' => $criteria,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('notification.notification.all.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
