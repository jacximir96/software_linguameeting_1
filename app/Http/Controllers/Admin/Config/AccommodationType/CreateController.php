<?php

namespace App\Http\Controllers\Admin\Config\AccommodationType;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\AccommodationType\Action\CreateAccommodationTypeAction;
use App\Src\StudentDomain\AccommodationType\Request\AccommodationTypeRequest;
use App\Src\StudentDomain\AccommodationType\Service\AccommodationTypeForm;
use Illuminate\Support\Facades\Log;


class CreateController extends Controller
{

    public function configView( )
    {

        $form = app(AccommodationTypeForm::class);
        $form->configForCreate();

        view()->share([
            'form' => $form,
        ]);

        return view('admin.config.accommodation-type.form');
    }


    public function create(AccommodationTypeRequest $request)
    {
        try {

            $action = app(CreateAccommodationTypeAction::class);
            $accommodationType = $action->handle($request);

            flash(trans('config.accommodation_type.create_success'))->success();

            return redirect()->route('get.admin.config.accommodation_type.edit', $accommodationType->hashId());

        } catch (\Throwable $exception) {



            Log::error('There is an error when create accommodation type.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.accommodation_type.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
