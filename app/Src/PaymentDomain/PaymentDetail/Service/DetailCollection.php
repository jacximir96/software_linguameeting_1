<?php
namespace App\Src\PaymentDomain\PaymentDetail\Service;

use App\Src\Shared\Model\Morpheable;
use Illuminate\Support\Collection;

class DetailCollection
{
    private Collection $detail;

    public function __construct (){
        $this->detail = collect();
    }

    public static function fromItem (Morpheable $item):self{

        $detail = new self();

        $detail->add($item);

        return $detail;
    }

    public static function fromCollection (Collection $items):self{

        $detail = new self();

        foreach ($items as $item){

            if ( ! $item instanceof Morpheable){
                throw new \InvalidArgumentException('Payment detail type invalid');
            }

            $detail->add($item);
        }

        return $detail;
    }

    public function get():Collection{
        return $this->detail;
    }

    public function add (Morpheable $model){
        $this->detail->push($model);
    }
}
