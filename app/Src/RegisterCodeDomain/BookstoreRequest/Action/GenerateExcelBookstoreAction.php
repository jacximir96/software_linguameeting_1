<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Action;

use App\Src\File\BookstoreRequestFile\Action\CreateRequestFileAction;
use App\Src\File\BookstoreRequestFile\Model\BookstoreRequestFile;
use App\Src\File\Service\PathBuilder;
use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;

use App\Src\RegisterCodeDomain\BookstoreRequestFileType\Model\BookstoreRequestFileType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class GenerateExcelBookstoreAction
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

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

        $sheet->setCellValue('A1', 'CODE');
        $sheet->setCellValue('B1', 'IS USED');

        $row = 2;
        foreach ($request->code()->cursor() as $code){
            $sheet->setCellValue('A' . $row, $code->code);
            $sheet->setCellValue('B' . $row, $code->is_used ? 'Yes' : 'No');
            $row++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);

        $targetPathFile = $this->pathBuilder->buildAbsoluteFilePath(BookstoreRequestFile::KEY_PATH, uniqid().'.xlsx');

        $writer = new Xlsx($spreadsheet);
        $writer->save($targetPathFile->path());

        $excelFileType = BookstoreRequestFileType::find(BookstoreRequestFileType::EXCEL_ID);

        return $this->createRequestFileAction->handle($request, $targetPathFile, $excelFileType);
    }
}
