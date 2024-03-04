<?php

namespace App\Src\CourseDomain\Course\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Presenter\Pdf\CourseSummaryPdfPresenter;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Presenter\Pdf\SectionInstructionsPdfPresenter;
use App\Src\File\Service\Attachment;
use App\Src\File\Service\PathBuilder;

class CourseFiles
{
    private CourseSummaryPdfPresenter $courseSummaryPdfPresenter;

    private SectionInstructionsPdfPresenter $sectionInstructionsPdfPresenter;

    private PathBuilder $pathBuilder;

    public function __construct(CourseSummaryPdfPresenter $courseSummaryPdfPresenter, SectionInstructionsPdfPresenter $sectionInstructionsPdfPresenter, PathBuilder $pathBuilder)
    {

        $this->courseSummaryPdfPresenter = $courseSummaryPdfPresenter;
        $this->sectionInstructionsPdfPresenter = $sectionInstructionsPdfPresenter;
        $this->pathBuilder = $pathBuilder;
    }

    public function obtainCourseSummaryPdf(Course $course): \Barryvdh\DomPDF\PDF
    {
        return $this->courseSummaryPdfPresenter->handle($course);
    }

    public function obtainSectionInstructionsPdf(Section $section): \Barryvdh\DomPDF\PDF
    {
        return $this->sectionInstructionsPdfPresenter->handle($section);
    }

    public function obtainCourseSummaryAsAttachment(Course $course): Attachment
    {

        $pdfCourseSummaryFile = $this->courseSummaryPdfPresenter->handle($course);

        $filename = $course->summaryFilename();

        $attachment = new Attachment($this->pathBuilder->buildStoragePath('attachments')->buildFile($filename), $filename);

        $pdfCourseSummaryFile->save($attachment->file()->path());

        return $attachment;
    }

    public function obtainSectionInstructionsAsAttachment(Section $section): Attachment
    {

        $pdfInstructionsFile = $this->sectionInstructionsPdfPresenter->handle($section);

        $filename = $section->summaryFilename();

        $attachment = new Attachment($this->pathBuilder->buildStoragePath('attachments')->buildFile($filename), $filename);

        $pdfInstructionsFile->save($attachment->file()->path());

        return $attachment;
    }
}
