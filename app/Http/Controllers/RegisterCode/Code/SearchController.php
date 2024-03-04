<?php

namespace App\Http\Controllers\RegisterCode\Code;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\RegisterCodeDomain\RegisterCode\Presenter\Breadcrumb\SearchBreadcrumb;
use App\Src\RegisterCodeDomain\RegisterCode\Repository\CodeRepository;
use App\Src\RegisterCodeDomain\RegisterCode\Service\SearchForm as SearchFormCode;
use App\Src\RegisterCodeDomain\BookstoreRequest\Service\SearchForm as SearchFormRequest;
use App\Src\UniversityDomain\University\Request\SearchUniversityRequest;

class SearchController extends Controller
{
    use Breadcrumable;

    private CodeRepository $codeRepository;

    public function __construct(CodeRepository $codeRepository)
    {
        $this->codeRepository = $codeRepository;
    }

    public function __invoke(SearchUniversityRequest $request)
    {
        $searchFormCode = app(SearchFormCode::class);
        $searchFormCode->config();

        $criteria = new CriteriaSearch($searchFormCode->model());
        $criteria->withoutPaginate();

        $codes = $this->codeRepository->search($criteria);

        $searchFormRequest = app(SearchFormRequest::class);
        $searchFormRequest->config();

        $breadcrumb = new SearchBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'searchFormRequest' => $searchFormRequest,
            'searchFormCode' => $searchFormCode,
            'codes' => $codes,
            'timezone' => $this->userTimezone(),
        ]);

        return view('admin.university.bookstore.code.index');
    }
}
