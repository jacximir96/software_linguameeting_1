<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Action;

use App\Src\File\BookstoreRequestFile\Action\CreateRequestFileAction;
use App\Src\File\BookstoreRequestFile\Model\BookstoreRequestFile;
use App\Src\File\Service\PathBuilder;
use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\RegisterCodeDomain\BookstoreRequestFileType\Model\BookstoreRequestFileType;
use setasign\Fpdi\Fpdi;

class GeneratePdfBookstoreAction
{
    private CreateRequestFileAction $createRequestFileAction;

    private PathBuilder $pathBuilder;

    public function __construct(CreateRequestFileAction $createRequestFileAction, PathBuilder $pathBuilder)
    {
        $this->createRequestFileAction = $createRequestFileAction;
        $this->pathBuilder = $pathBuilder;
    }

    public function handle(BookstoreRequest $request): BookstoreRequestFile
    {
        $pdf = new Fpdi();

        foreach ($request->code()->cursor() as $code){

            $pdf->SetMargins(10, 5, 10); // before add page
            $pdf->AddPage();

            // header
            $pdf->Image(asset('assets/img/logo_anagrama.png'), 10, 8, 50);
            $pdf->Line(10, 15, 200, 15);
            $pdf->Ln(20);
            // end header
            $pdf->SetFont('Arial', '', 17);
            $pdf->SetX(10);
            $pdf->SetTextColor(53, 180, 180);
            $pdf->Write(5, "Linguameeting Live Language Coaching Student Information Sheet");
            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetX(10);
            $pdf->Write(5, $request->conversationPackage->name. ' - ' .$request->conversationPackage->duration_session. ' min.');
            $pdf->Ln();
            $pdf->SetX(10);
            $pdf->Write(5, 'ISBN: ' . $request->conversationPackage->isbn);
            $pdf->SetTextColor(0);
            $pdf->Ln(20);
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetX(10);
            $pdf->Write(5, "Congratulations!");
            $pdf->Ln(10);
            $pdf->SetX(10);
            $pdf->Write(5, utf8_decode("You have signed up for a great opportunity to develop and practice your conversational skills. During the semester, you will engage in 30/15-minute online group/individual coaching sessions with a native-speaking language coach. The coach will help you reinforce what you have learned in class and encourage you to participate in each conversation, in Spanish. Here's some additional information about the LinguaMeeting experience:"));
            $pdf->Ln(20);

            $pdf->Write(5, "How do I get started?");
            $pdf->Ln(10);
            $pdf->SetX(20);
            $pdf->Write(5, "1. Go to ");
            $pdf->SetTextColor(0, 0, 255);
            $pdf->Write(5, route('get.public.register.student.code'), route('get.public.register.student.code'));


            $pdf->Ln();
            $pdf->SetTextColor(0);
            $pdf->SetX(20);
            $pdf->Write(5, "2. Enter the Class ID.");
            $pdf->Ln();
            $pdf->SetX(20);
            $pdf->Write(5, "3. Create a user name, password and ENTER THE LINGUAMEETING CODE.");
            $pdf->Ln();
            $pdf->SetX(20);

            $pdf->Write(5, "4. After you will be prompted to choose from the available session times.
                  Your session will always be on the same day of the week and at the same
                  time of day unless you change it.");

            $pdf->Ln(20);
            $pdf->SetX(10);
            $pdf->Write(5, "Contact Support at ");
            $pdf->SetTextColor(0, 0, 255);
            $pdf->Write(5, route('support'), route('support'));
            $pdf->SetTextColor(0);
            $pdf->Write(5, " for questions.");


            $pdf->Ln(20);
            $pdf->SetFont('Arial', '', 25);
            $pdf->SetTextColor(53, 180, 180);
            $pdf->Cell(0, 10, "LINGUAMEETING CODE: ");
            $pdf->Ln(20);
            $pdf->SetTextColor(0);
            $pdf->Cell(0, 10, $code->code);


        }

        $targetPathFile = $this->pathBuilder->buildAbsoluteFilePath(BookstoreRequestFile::KEY_PATH, uniqid().'.pdf');

        $pdf->Output($targetPathFile->path(), 'F');

        $pdfTypeFile = BookstoreRequestFileType::find(BookstoreRequestFileType::PDF_ID);

        return $this->createRequestFileAction->handle($request, $targetPathFile, $pdfTypeFile);
    }
}
