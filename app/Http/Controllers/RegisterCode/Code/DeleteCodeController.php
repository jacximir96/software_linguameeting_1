<?php
namespace App\Http\Controllers\RegisterCode\Code;

use App\Http\Controllers\Controller;
use App\Src\RegisterCodeDomain\RegisterCode\Action\DeleteCodeAction;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DeleteCodeController extends Controller
{

    public function __invoke(RegisterCode $registerCode)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteCodeAction::class);
            $action->handle($registerCode);

            DB::commit();

            flash(trans('student.register-code.delete_succes'))->success();

            return back();

        } catch (RegisterCodeIsUsed $exception){

            DB::rollback();

            flash(trans('student.register-code.error.on_delete_is_used'))->error();

            return back();
        }

        catch (\Exception $exception) {

            DB::rollback();

            Log::error('Error deleting register code', [
                'registerCode' => $registerCode,
                'exception' => $exception,
            ]);

            flash(trans('student.register-code.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
