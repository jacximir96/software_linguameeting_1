<?php

namespace App\Http\Controllers\RegisterCode\BookstoreRequest;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\RegisterCodeDomain\RegisterCode\Repository\CodeRepository;
use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb\ShowBreadcrumb;
use App\Src\RegisterCodeDomain\BookstoreRequest\Repository\RequestRepository;
use App\Src\RegisterCodeDomain\BookstoreRequest\Service\SearchForm;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\Shared\Service\Order;

class ShowController extends Controller
{
    use Breadcrumable;

    private RequestRepository $requestRepository;

    private CodeRepository $codeRepository;

    public function __construct(RequestRepository $requestRepository, CodeRepository $codeRepository)
    {
        $this->requestRepository = $requestRepository;
        $this->codeRepository = $codeRepository;
    }

    public function __invoke(BookstoreRequest $request)
    {
        $this->requestRepository->eagerLoading($request);

        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $numDeletedCodes = $this->codeRepository->countRequestCodeDeleted($request);
        $numUsedCodes = $this->codeRepository->countRequestCodeUsed($request);

        $this->buildBreadcrumbAndSendToView(ShowBreadcrumb::SLUG);

        $codes = $this->searchCodes($request);

        view()->share([
            'codes' => $codes,
            'numDeletedCodes' => $numDeletedCodes,
            'numUsedCodes' => $numUsedCodes,
            'searchForm' => $searchForm,
            'request' => $request,
            'timezone' => $this->userTimezone(),
        ]);

        return view('admin.university.bookstore.request.show');
    }

    private function searchCodes(BookstoreRequest $request)
    {
        $fields = ['bookstore_request_id' => $request->id];
        $criteria = new CriteriaSearch($fields);
        $criteria->withoutPaginate();
        $order = new Order('code');
        $criteria->withOrder($order);

        $codes = $this->codeRepository->search($criteria);

        return $codes;
    }
}
