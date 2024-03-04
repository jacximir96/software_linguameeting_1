<?php
namespace App\Src\ThirdPartiesDomain\Lingro\Model;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class LingroRegister extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'lingro_register';

    protected $dates = ['registered_at', 'created_at', 'updated_at', 'deleted_at'];

}
