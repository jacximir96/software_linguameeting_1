<?php
namespace App\Http\Controllers\Instructor\Alerts;


use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\UserDomain\User\Service\EditInstructorAlertForm;


class EditAlertsController extends Controller
{
    use Breadcrumable;

    public function configView()
    {

        $this->buildBreadcrumbAndSendToView(EditInstructorAlertForm::SLUG);

        view()->share([
            'user' => user(),
        ]);

        return view('user.profile.alert_form');
    }

    public function update()
    {
        try {

            

        } catch (\Throwable $exception) {

            
        }
    }
}
