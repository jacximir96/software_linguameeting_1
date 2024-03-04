<?php

namespace App\Http\Controllers\Admin\Coach\Feedback;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service\CoachFeedbackWrapper;
use App\Src\CoachDomain\FeedbackDomain\FeedbackObservation\Model\FeedbackObservation;
use App\Src\CoachDomain\FeedbackDomain\FeedbackSubtype\Model\FeedbackSubtype;
use App\Src\CoachDomain\FeedbackDomain\FeedbackType\Model\FeedbackType;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;


class DownloadFeedbackController extends Controller
{

    public function __invoke(CoachFeedback $coachFeedback)
    {
        try {

            $wrapper = new CoachFeedbackWrapper($coachFeedback);

            $types = FeedbackType::all()->keyBy('id')->sortKeys();

            $observations = FeedbackObservation::all()->keyBy('id')->sortKeys();

            $subtypes = FeedbackSubtype::all()->keyBy('id')->sortKeys();

            /*
            view()->share([
                'coach' => $coachFeedback->coach,
                'observations' => $observations,
                'types' => $types,
                'subtypes' => $subtypes,
                'wrapper' => $wrapper,

            ]);

            return view('admin.coach.feedback.file.index');
            */

            $dataBackground = file_get_contents(public_path('assets/img/background_page_pdf.png'));
            $typeBackground = mime_content_type(public_path('assets/img/background_page_pdf.png'));
            $backgroundBase64 = 'data:' . $typeBackground . ';base64,' . base64_encode($dataBackground);

            $data = [
                'backgroundBase64' => $backgroundBase64,
                'coach' => $coachFeedback->coach,
                'observations' => $observations,
                'types' => $types,
                'subtypes' => $subtypes,
                'wrapper' => $wrapper,
            ];

            $pdf = PDF::loadView('admin.coach.feedback.file.index', $data);

            return $pdf->download('coach_feedback.pdf');


        } catch (\Throwable $exception) {

            Log::error('There is an error when download feedback file', [
                'coachFeedback' => $coachFeedback,
                'exception' => $exception,
            ]);

            flash('Se produjo un error al descargar el feedback del coach.')->error();

            return back();
        }
    }
}
