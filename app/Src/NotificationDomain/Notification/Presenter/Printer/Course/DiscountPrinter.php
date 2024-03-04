<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Course;

use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Illuminate\Support\Collection;


class DiscountPrinter extends FieldPrinter
{

    public function __construct (array $data){
        parent::__construct($data);
    }

    public function key(): string
    {
        return $this->data()['key'];
    }

    public function keyField(): string
    {
        return 'amount_discount';
    }

    public function nameField(): string
    {
        return 'Discount';
    }

    public function change (string $moment):Collection{

        $changes = collect();

        if (isset($this->data()['values'][$this->keyField()])){

            $value = $this->data()['values'][$this->keyField()]['values'][$moment];

            if (empty($value)) {
                $value = '-';
            }
            else{

                $linguaMoney = new LinguaMoney();
                $discount = $linguaMoney->buildFromCents($value);
                $value = $linguaMoney->format($discount);
            }

            $value = new Value($this->nameField(), $value);
            $changes->push($value);
        }

        return $changes;
    }
}
