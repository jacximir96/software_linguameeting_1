<?php
namespace App\Src\NotificationDomain\Notification\Service;


use Illuminate\Support\Collection;

class ChangeCollection
{

    private Collection $changes;

    public function __construct (){
        $this->changes = collect();
    }

    public function get():Collection{
        return $this->changes;
    }

    public function hasChanges():bool{
        return (bool)$this->changes->count();
    }

    public function addChange (ChangedField $changedField){
        $this->changes->push($changedField);
    }

    public function convertToDataExtraItems ():Collection{

        $extras = collect();

        foreach ($this->changes as $changeField){
            $extras->push($changeField->convertToDataExtraItem());
        }

        return $extras;
    }
}
