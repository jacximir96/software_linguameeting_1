<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookstore_request_file_type', function (Blueprint $table) {

            $table->id();
            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        $file = new \App\Src\RegisterCodeDomain\BookstoreRequestFileType\Model\BookstoreRequestFileType();
        $file->name = 'PDF';
        $file->save();

        $file = new \App\Src\RegisterCodeDomain\BookstoreRequestFileType\Model\BookstoreRequestFileType();
        $file->name = 'EXCEL';
        $file->save();


        Schema::table('bookstore_request_file', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->nullable()->after('bookstore_request_id');
            $table->foreign('type_id', 'request_file_type')->references('id')->on('bookstore_request_file_type');

        });

        $files = \App\Src\File\BookstoreRequestFile\Model\BookstoreRequestFile::withTrashed()->get();
        foreach ($files as $file){
            $file->type_id = 1;
            $file->save();
        }
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookstore_request_file', function (Blueprint $table) {
            //
        });
    }
};
