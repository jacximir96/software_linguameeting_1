<?php

namespace App\Src\File\BookstoreRequestFile\Model;

use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\RegisterCodeDomain\BookstoreRequestFileType\Model\BookstoreRequestFileType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class BookstoreRequestFile extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const KEY_PATH = 'bookstore_request';

    protected $table = 'bookstore_request_file';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function request()
    {
        return $this->belongsTo(BookstoreRequest::class);
    }

    public function type (){
        return $this->belongsTo(BookstoreRequestFileType::class, 'type_id');
    }
}
