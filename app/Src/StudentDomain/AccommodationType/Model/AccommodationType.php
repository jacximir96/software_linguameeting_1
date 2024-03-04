<?php

namespace App\Src\StudentDomain\AccommodationType\Model;

use App\Src\Shared\Model\HashIdable;
use App\Src\StudentDomain\Accommodation\Model\Accommodation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AccommodationType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'accommodation_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function hasIndividualSession(): bool
    {
        return (bool) $this->individual_session;
    }
}
