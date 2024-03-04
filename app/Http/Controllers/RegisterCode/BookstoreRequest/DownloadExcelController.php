<?php
namespace App\Http\Controllers\RegisterCode\BookstoreRequest;

use App\Http\Controllers\Controller;
use App\Src\File\BookstoreRequestFile\Model\BookstoreRequestFile;
use App\Src\File\Service\PathBuilder;
use App\Src\RegisterCodeDomain\BookstoreRequest\Action\GenerateExcelBookstoreAction;
use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\RegisterCodeDomain\BookstoreRequestFileType\Model\BookstoreRequestFileType;


class DownloadExcelController extends Controller
{
    private PathBuilder $pathBuilder;

    public function __construct(PathBuilder $pathBuilder)
    {
        $this->pathBuilder = $pathBuilder;
    }

    public function __invoke(BookstoreRequest $request)
    {

        $excelType = BookstoreRequestFileType::find(BookstoreRequestFileType::EXCEL_ID);

        if( ! $request->hasTypeFile($excelType)){
            $action = app(GenerateExcelBookstoreAction::class);
            $action->handle($request);
        }

        $request->refresh();

        $file = $request->obtainTypeFile($excelType);

        $filePath = $this->pathBuilder->buildAbsoluteFilePath(BookstoreRequestFile::KEY_PATH, $file->filename);

        return response()->download($filePath->path(), $file->original_name, [
            'Content-Type' => $file->mime,
            'Cache-Control' => 'no-cache, must-revalidate',
            'Content-Disposition' => 'attachment; filename="'.$file->original_name.'"',
        ]);
    }
}
