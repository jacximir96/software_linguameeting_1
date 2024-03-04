<?php

namespace App\Http\Controllers\RegisterCode\BookstoreRequest;

use App\Http\Controllers\Controller;
use App\Src\RegisterCodeDomain\RegisterCode\Exception\CodeIsUsed;
use App\Src\RegisterCodeDomain\BookstoreRequest\Action\DeleteRequestAction;
use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteController extends Controller
{
    public function __invoke(BookstoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $action = app(DeleteRequestAction::class);
            $action->handle($request);

            DB::commit();

            flash(trans('university.bookstore.code.delete_success'))->success();

            return back();
        } catch (CodeIsUsed $exception) {
            flash(trans('university.bookstore.request.not_modified_is_used'))->warning();

            return back();
        } catch (\Exception $exception) {
            Log::error(trans('university.bookstore.code.not_delete_is_used'), [
                'code' => $code,
                'exception' => $exception,
            ]);

            flash(trans('university.bookstore.code.not_delete_error'))->error();

            return back();
        }
    }
}
