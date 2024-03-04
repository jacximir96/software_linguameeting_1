<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Model;

use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\File\BookstoreRequestFile\Model\BookstoreRequestFile;
use App\Src\RegisterCodeDomain\BookstoreRequestFileType\Model\BookstoreRequestFileType;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\UniversityDomain\University\Model\University;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class BookstoreRequest extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'bookstore_request';

    protected $dates = ['date_request', 'created_at', 'updated_at', 'deleted_at'];

    public function code()
    {
        return $this->hasMany(RegisterCode::class, 'bookstore_request_id');
    }

    public function conversationPackage()
    {
        return $this->belongsTo(ConversationPackage::class);
    }

    public function file()
    {
        return $this->hasMany(BookstoreRequestFile::class, 'bookstore_request_id');
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function codeOrderByCode()
    {
        return $this->code->sortBy(function ($code) {
            return $code->code;
        });
    }

    public function hasTypeFile(BookstoreRequestFileType $type):bool{

        foreach ($this->file as $file){
            if ($file->type->isSame($type)){
                return true;
            }
        }

        return false;
    }

    public function obtainTypeFile(BookstoreRequestFileType $type):BookstoreRequestFile{

        foreach ($this->file as $file){
            if ($file->type->isSame($type)){
                return $file;
            }
        }
    }
}
