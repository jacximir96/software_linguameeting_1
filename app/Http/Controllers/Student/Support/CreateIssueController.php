<?php
namespace App\Http\Controllers\Student\Support;

use App\Http\Controllers\Controller;
use App\Src\HelpDomain\Issue\Action\CreateIssueAction;
use App\Src\HelpDomain\Issue\Request\IssueRequest;
use App\Src\ThirdPartiesDomain\Jira\Action\Command\SendIssueCommand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateIssueController extends Controller
{

    public function create(IssueRequest $request)
    {
        try {

            DB::beginTransaction();;

            $action = app(CreateIssueAction::class);
            $issue = $action->handle($request, user());

            $action = app(SendIssueCommand::class);
            $action->handle($issue);

            DB::commit();

            flash(trans('issue.create_success'))->success();

            return back();
        }
        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('When create issue from student panel.', [
                'user' => user(),
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('issue.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
