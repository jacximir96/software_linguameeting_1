<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class LeaveImpersonationController extends Controller
{
    public function __invoke()
    {
        try {

            user()->leaveImpersonation();

            flash(trans('user.leave_impersonation_success'))->success();

            return redirect()->route('get.admin.dashboard.index');

        } catch (\Throwable $exception) {

            Log::error('There is an error when leave impersonate', [
                'exception' => $exception,
            ]);

            flash(trans('user.error.on_leave_impersonation'))->error();

            return back();
        }
    }
}
