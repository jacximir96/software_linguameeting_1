<?php

namespace App\Http\Controllers\Admin\Config\AccommodationType;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\AccommodationType\Action\DeleteAccommodationTypeAction;
use App\Src\StudentDomain\AccommodationType\Model\AccommodationType;
use Illuminate\Support\Facades\Log;


class DeleteController extends Controller
{

    public function __invoke(AccommodationType $accommodationType)
    {
        try {

            $action = app(DeleteAccommodationTypeAction::class);
            $action->handle($accommodationType);

            flash(trans('config.accommodation_type.delete_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when delete accommodation type.', [
                'accommodationType' => $accommodationType,
                'exception' => $exception,
            ]);

            flash(trans('config.accommodation_type.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
