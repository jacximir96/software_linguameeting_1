<?php
namespace App\Src\RegisterCodeDomain\RegisterCode\Model;


use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class RegisterCode extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'register_code';

    protected $dates = ['used_at', 'created_at', 'updated_at', 'deleted_at'];

    public function payment()
    {
        return $this->hasOne(Payment::class, 'register_code_id')->withTrashed();
    }

    public function request()
    {
        return $this->belongsTo(BookstoreRequest::class, 'bookstore_request_id');
    }

    public function isUsed(): bool
    {
        return $this->is_used;
    }
}
