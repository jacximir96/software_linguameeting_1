<?php

namespace App\Src\CoachDomain\InvoiceDomain\Invoice\Model;

use App\Src\CoachDomain\InvoiceDomain\InvoiceDetail\Model\InvoiceDetail;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Model\HashIdable;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Money\Money;
use OwenIt\Auditing\Contracts\Auditable;

class Invoice extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'coach_invoice';

    protected $dates = ['date', 'created_at', 'updated_at', 'deleted_at'];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function detail()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }

    public function number(): string
    {

        $month = $this->month();

        return $this->coach_id.'-'.$month->year().'-'.$month->monthWithZero().'-'.$this->number;
    }

    public function filename(string $extension = 'pdf'): string
    {
        return 'invoice_'.$this->number().'.'.$extension;
    }

    public function month(): Month
    {
        return new Month($this->month, $this->year);
    }

    public function total(): Money
    {

        $linguaMoney = new LinguaMoney();

        $total = $linguaMoney->buildZero($this->currency);

        if (! $this->detail->count()) {
            return $total;
        }

        foreach ($this->detail as $detail) {
            $total = $total->add($detail->price());
        }

        return $total;
    }

    public function isOlder(Invoice $otherInvoice): bool
    {

        if ($this->year > $otherInvoice->year) {
            return true;
        } elseif ($this->year == $otherInvoice->year) {

            if ($this->number > $otherInvoice->number) {
                return true;
            }
        }

        return false;
    }
}
