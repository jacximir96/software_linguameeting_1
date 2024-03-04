<?php

namespace App\Http\Controllers\Admin\Coach\EvaluationManager;

use App\Http\Controllers\Controller;
use App\Src\UserDomain\User\Model\User;

class ShowEvaluationManagerController extends Controller
{
    public function __invoke(User $coach)
    {
        $coach->load('evaluationManager', 'evaluationManager.file');
dd($coach);
        $evaluations = $coach->evaluationManager->sortByDesc(function ($evaluation) {
            return $evaluation->evaluation_at->toDateString();
        });

        view()->share([
            'coach' => $coach,
            'evaluations' => $evaluations,
        ]);

        return view('admin.coach.evaluation.show');
    }
}
