<?php
namespace App\Src\RegisterCodeDomain\BookstoreRequestFileType\Model;

use App\Src\File\BookstoreRequestFile\Model\BookstoreRequestFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class BookstoreRequestFileType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const PDF_ID = 1;
    const EXCEL_ID = 2;

    protected $table = 'bookstore_request_file_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function file()
    {
        return $this->hasMany(BookstoreRequestFile::class, 'type_id');
    }

    public function isSame (BookstoreRequestFileType $type):bool{
        return $this->id == $type->id;
    }
}
