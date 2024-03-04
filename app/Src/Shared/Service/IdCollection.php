<?php

namespace App\Src\Shared\Service;

use App\Src\Shared\Model\ValueObject\Id;
use Illuminate\Support\Collection;

class IdCollection
{
    private Collection $ids;

    public function __construct()
    {
        $this->ids = collect();
    }

    public function get(): Collection
    {
        return $this->ids;
    }

    public function add(Id $id)
    {
        $this->ids->push(($id));
    }

    public function toArray(): array
    {

        return $this->ids->map(function ($id) {
            return $id->get();
        })->toArray();
    }
}
