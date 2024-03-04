<?php
namespace App\Src\NotificationDomain\Notification\Service\DataExtra;


use Illuminate\Support\Collection;


class DataExtraCollection
{
    private string $key;

    private Collection $items;

    public function __construct (string $key){

        $this->key = $key;
        $this->items = collect();
    }

    public function key():string{
        return $this->key;
    }

    public function items ():Collection{
        return $this->items;
    }

    public function add(DataExtraItem $extraItem){
        $this->items->push($extraItem);
    }

    public function toArray():array{

        $data = [
            'key' => $this->key,
            'values' => []
        ];

        foreach ($this->items as $dataExtraItem){

            $itemToArray = $dataExtraItem->toArray();
            $key = $itemToArray['key'];
            $data['values'][$key] = $itemToArray;
        }

        return $data;
    }
}
