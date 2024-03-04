<?php

namespace App\Src\ConversationPackageDomain\PackageOffer\Model;

use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\PaymentDomain\Money\Service\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ConversationPackageOffer extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'conversation_package_offer';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'price' => MoneyCast::class,
    ];

    public function sessionType()
    {
        return $this->belongsTo(SessionType::class);
    }
}
