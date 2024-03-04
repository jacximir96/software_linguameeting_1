<?php

namespace App\Http\Controllers\RegisterCode\BookstoreRequest;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\RegisterCodeDomain\BookstoreRequest\Action\CreateRequestAction;
use App\Src\RegisterCodeDomain\BookstoreRequest\Action\GeneratePdfBookstoreAction;
use App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb\CreateBreadcrumb;
use App\Src\RegisterCodeDomain\BookstoreRequest\Request\BookstoreRequest;
use App\Src\RegisterCodeDomain\BookstoreRequest\Service\RequestForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    use Breadcrumable;

    public function configView()
    {
        $form = app(RequestForm::class);
        $form->configToCreate();

        $this->buildBreadcrumbAndSendToView(CreateBreadcrumb::SLUG);

        view()->share([
            'form' => $form,
        ]);

        return view('admin.university.bookstore.request.form');
    }

    public function create(BookstoreRequest $bookstoreRequest)
    {
        try {
            DB::beginTransaction();

            $action = app(CreateRequestAction::class);
            $request = $action->handle($bookstoreRequest);

            $action = app(GeneratePdfBookstoreAction::class);
            $action->handle($request);

            DB::commit();

            flash(trans('university.bookstore.request.create_success'))->success();

            return redirect()->route('get.admin.register_code.bookstore_request.index', $request);
        } catch (\Exception $exception) {

            Log::error('Error create bookstore request', [
                'request' => $bookstoreRequest,
                'exception' => $exception,
            ]);

            flash(trans('university.bookstore.request.create_error'))->error();

            return back()->withInput();
        }
    }
}
