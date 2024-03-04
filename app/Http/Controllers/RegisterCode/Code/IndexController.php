<?php
namespace App\Http\Controllers\RegisterCode\Code;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\RegisterCodeDomain\BookstoreRequest\Service\SearchForm as SearchFormRequest;
use App\Src\RegisterCodeDomain\RegisterCode\Presenter\Breadcrumb\SearchBreadcrumb;
use App\Src\RegisterCodeDomain\RegisterCode\Repository\CodeRepository;
use App\Src\RegisterCodeDomain\RegisterCode\Service\SearchForm as SearchFormCode;


class IndexController extends Controller
{
    use Breadcrumable;

    private CodeRepository $codeRepository;

    public function __construct (CodeRepository $codeRepository){

        $this->codeRepository = $codeRepository;
    }

    public function __invoke()
    {

        $searchFormCode = app(SearchFormCode::class);
        $searchFormCode->config();

        $codes = $this->codeRepository->obtainCodesForIndex();

        $searchFormRequest = app(SearchFormRequest::class);
        $searchFormRequest->config();

        $this->buildBreadcrumbAndSendToView(SearchBreadcrumb::SLUG);


        view()->share([
            'codes' => $codes,
            'searchFormCode' => $searchFormCode,
            'searchFormRequest' => $searchFormRequest,
        ]);

        return view('admin.university.bookstore.code.index');
    }
}
