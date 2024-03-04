<?php

namespace App\Http\Controllers\RegisterCode\Code;

use App\Http\Controllers\Controller;
use App\Src\RegisterCodeDomain\RegisterCode\Action\DeleteCodeAction;
use App\Src\RegisterCodeDomain\RegisterCode\Exception\CodeIsUsed;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use Illuminate\Support\Facades\Log;

class DeleteController extends Controller
{
    public function __invoke(RegisterCode $code)
    {
        try {
            $action = app(DeleteCodeAction::class);
            $action->handle($code);

            flash(trans('university.bookstore.code.delete_success'))->success();

            return back();
        } catch (CodeIsUsed $exception) {
            flash(trans('university.bookstore.code.not_modified_is_used'))->warning();

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
