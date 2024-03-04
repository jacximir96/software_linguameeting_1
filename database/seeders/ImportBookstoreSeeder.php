<?php

namespace Database\Seeders;

use App\Src\_Old\Model\SpecialCodes;
use App\Src\_Old\Model\SpecialCodesRequest;
use App\Src\File\BookstoreRequestFile\Model\BookstoreRequestFile;
use App\Src\File\Service\PathBuilder;
use App\Src\StudentDomain\RegisterCode\Model\NoRegisterCode;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportBookstoreSeeder extends Seeder
{

    use TraitImport;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->importCodesWithoutRequest();

        $this->importRequest();
    }

    private function importCodesWithoutRequest(){

        $codesOld = SpecialCodes::where('request_id', 0)->orderBy('id_special_code')->get();

        foreach ($codesOld as $codeOld){

            if ($codeOld->id_university){
                $codeNew = new RegisterCode();
                $codeNew->id = $codeOld->id_special_code;
                $codeNew->code = $codeOld->code_special;
                $codeNew->is_used = $codeOld->used;
                $codeNew->save();
            }
        }
    }

    private function importRequest(){

        $itemsOld = SpecialCodesRequest::orderBy('request_id')->get();

        foreach ($itemsOld as $oldItem){

            //request
            $newItem = new BookstoreRequest();
            $newItem->id = $oldItem->request_id;
            $newItem->university_id = $oldItem->university_id;
            $newItem->conversation_package_id = $oldItem->type_code;
            $newItem->num_codes = $oldItem->number_codes;
            $newItem->date_request = $oldItem->request_date;
            $newItem->save();

            //file
            $this->processFile($oldItem);

            //codes
            $codesOld = SpecialCodes::where('request_id', $oldItem->request_id)->orderBy('id_special_code')->get();

            foreach ($codesOld as $codeOld){

                $codeNew = new RegisterCode();
                $codeNew->id = $codeOld->id_special_code;
                $codeNew->bookstore_request_id = $codeOld->request_id;
                $codeNew->code = $codeOld->code_special;
                $codeNew->is_used = $codeOld->used;

                $codeNew->save();
            }
        }
    }

    private function processFile (SpecialCodesRequest $oldItem){

        $pathBuilder = new PathBuilder();

        $path = $pathBuilder->buildPublicAbsolutePath(BookstoreRequestFile::KEY_PATH);

        $oldFilename = basename($oldItem->url_pdf);

        if ($path->hasFile($oldFilename)){

            $file = new BookstoreRequestFile();
            $file->bookstore_request_id = $oldItem->request_id;
            $file->filename = $oldFilename;
            $file->original_name = $oldFilename;

            $pathInfo = pathinfo($oldFilename);
            $file->mime = $this->obtainMime($pathInfo['extension']);

            $file->save();
        }
    }
}
