<?php
namespace App\Http\Controllers\Admin\Calendar;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\Session\Action\BlockSessionAction;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;


class BlockSessionController extends Controller
{

    public function __invoke(Session $session)
    {

        $action = app(BlockSessionAction::class);
        $action->handle($session);

        flash(trans('calendar.session.block.success'))->success();

        return back();
    }
}
