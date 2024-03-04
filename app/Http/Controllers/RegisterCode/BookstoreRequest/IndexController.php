<?php

namespace App\Http\Controllers\RegisterCode\BookstoreRequest;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\RegisterCodeDomain\RegisterCode\Service\SearchForm as SearchFormCode;
use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\RegisterCodeDomain\BookstoreRequest\Repository\RequestRepository;
use App\Src\RegisterCodeDomain\BookstoreRequest\Service\SearchForm;

class IndexController extends Controller
{
    use Breadcrumable;

    private RequestRepository $requestRepository;

    public function __construct(RequestRepository $requestRepository)
    {
        $this->requestRepository = $requestRepository;
    }

    public function __invoke(?BookstoreRequest $newRequest)
    {
        $searchFormRequest = app(SearchForm::class);
        $searchFormRequest->config();

        $criteria = new CriteriaSearch($searchFormRequest->model());
        $requests = $this->requestRepository->search($criteria);

        $searchFormCode = app(SearchFormCode::class);
        $searchFormCode->config();

        $breadrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadrumb);

        if (session()->has('registerCode')){
            view()->share('registerCode', session()->get('registerCode'));
        }

        view()->share([
            'newRequest' => $newRequest,
            'searchFormRequest' => $searchFormRequest,
            'searchFormCode' => $searchFormCode,
            'requests' => $requests,
        ]);

        return view('admin.university.bookstore.request.index');
    }
}
