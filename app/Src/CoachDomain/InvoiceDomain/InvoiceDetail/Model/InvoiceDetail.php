<?php

namespace App\Src\CoachDomain\InvoiceDomain\InvoiceDetail\Model;

use App\Src\CoachDomain\InvoiceDomain\Invoice\Model\Invoice;
use App\Src\PaymentDomain\Money\Service\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Money\Money;
use OwenIt\Auditing\Contracts\Auditable;

class InvoiceDetail extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'coach_invoice_detail';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'unit_price' => MoneyCast::class,
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function price(): Money
    {
        return $this->unit_price->multiply($this->quantity);
    }
}
