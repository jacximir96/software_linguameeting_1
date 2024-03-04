<?php

namespace App\Http\Controllers\Admin\Config\AccommodationType;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\AccommodationType\Model\AccommodationType;
use App\Src\StudentDomain\AccommodationType\Action\UpdateAccommodationTypeAction;
use App\Src\StudentDomain\AccommodationType\Request\AccommodationTypeRequest;
use App\Src\StudentDomain\AccommodationType\Service\AccommodationTypeForm;
use Illuminate\Support\Facades\Log;


class EditController extends Controller
{

    public function configView(AccommodationType $accommodationType)
    {

        $form = app(AccommodationTypeForm::class);
        $form->configForEdit($accommodationType);

        view()->share([
            'accommodationType' => $accommodationType,
            'form' => $form,
        ]);

        return view('admin.config.accommodation-type.form');
    }

    public function update(AccommodationTypeRequest $request, AccommodationType $accommodationType)
    {
        try {

            $action = app(UpdateAccommodationTypeAction::class);
            $action->handle($request, $accommodationType);

            flash(trans('config.accommodation_type.update_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update accommodation type.', [
                'accommodationType' => $accommodationType,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.accommodation_type.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
