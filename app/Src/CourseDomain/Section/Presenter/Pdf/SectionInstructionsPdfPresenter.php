<?php

namespace App\Src\CourseDomain\Section\Presenter\Pdf;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Presenter\InstructionsPresenter;
use Barryvdh\DomPDF\Facade\Pdf;

class SectionInstructionsPdfPresenter
{
    private InstructionsPresenter $instructionsPresenter;

    public function __construct(InstructionsPresenter $instructionsPresenter)
    {

        $this->instructionsPresenter = $instructionsPresenter;
    }

    public function handle(Section $section): \Barryvdh\DomPDF\PDF
    {
        $viewData = $this->instructionsPresenter->handle($section);

        view()->share(['viewData' => $viewData]);

        //uncomment for test in view
        //return view('admin.section.file.instructions.index');

        $pdf = PDF::loadView('admin.section.file.instructions.index', compact('section'));
        //$pdf->save($targetPathFile->path());
        //return $pdf->stream();
        return $pdf;
    }
}
