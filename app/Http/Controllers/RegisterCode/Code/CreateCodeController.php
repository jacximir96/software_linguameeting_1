<?php
namespace App\Http\Controllers\RegisterCode\Code;

use App\Http\Controllers\Controller;
use App\Src\RegisterCodeDomain\RegisterCode\Action\CreateCodeAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateCodeController extends Controller
{

    public function __invoke()
    {
        try {

            DB::beginTransaction();

            $action = app(CreateCodeAction::class);
            $registerCode = $action->handle();

            DB::commit();

            request()->session()->flash('new-code-generated', $registerCode->code);

            return redirect()->route('get.admin.register_code.code.index');

        } catch (\Exception $exception) {


            DB::rollback();

            Log::error('Error create register code', [
                'exception' => $exception,
            ]);

            flash(trans('student.register-code.error.on_create'))->error();

            return redirect()->route('get.admin.register_code.bookstore_request.index');
        }
    }
}
