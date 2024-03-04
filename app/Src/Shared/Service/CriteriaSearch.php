<?php

namespace App\Src\Shared\Service;

use App\Src\UserDomain\Status\Service\StatusFactory;
use Carbon\Carbon;

class CriteriaSearch
{
    private array $fields;

    private bool $paginate = true;

    private ?int $sizePage = null;

    private ?int $limit = null;

    private ?Order $order = null;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function fields(): array
    {
        return $this->fields;
    }

    public function get(string $field)
    {
        return $this->fields[$field];
    }

    public function getMultiple(string $field): array
    {

        if (! $this->searchByMultiple($field)) {
            return [];
        }

        $values = [];
        foreach ($this->fields[$field] as $value) {
            if (! is_null($value)) {
                $values[] = $value;
            }
        }

        return $values;
    }

    public function set(string $field, $value)
    {
        $this->fields[$field] = $value;
    }

    public function getDate(string $field): Carbon
    {
        return Carbon::parse($this->get($field));
    }

    public function hasValue(string $field): bool
    {

        if (! isset($this->fields[$field])) {
            return false;
        }

        $value = $this->fields[$field];

        if ($value === null) {
            return false;
        }

        return true;
    }

    public function searchBy(string $field): bool
    {
        if (! isset($this->fields[$field])) {
            return false;
        }

        if ($this->fields[$field] == '0') {
            return true;
        }

        return ! empty($this->fields[$field]);
    }

    public function searchByMultiple(string $field): bool
    {
        if (! isset($this->fields[$field])) {
            return false;
        }

        if (! is_array($this->fields[$field])) {
            return false;
        }

        foreach ($this->fields[$field] as $value) {

            if (! is_null($value)) {
                return true;
            }
        }

        return false;
    }

    public function searchActive(int $enabledDefaultValue = StatusFactory::ID_ENABLED): bool
    {

        if (! $this->hasValue('status')) {
            return true;
        }

        $status = (int) $this->get('status');

        return $status === $enabledDefaultValue;
    }

    public function searchDeactivated(int $disabledDefaultValue = StatusFactory::ID_DISABLED)
    {
        if (! $this->hasValue('status')) {
            return false;
        }

        $inactive = (int) $this->get('status');

        return $inactive === $disabledDefaultValue;
    }

    public function searchByCustomStatus(int $statusValue)
    {
        if (! $this->hasValue('status')) {
            return false;
        }

        $statusSelected = (int) $this->get('status');

        return $statusSelected === $statusValue;
    }

    public function searchBlocked(int $blockedDefaultValue = StatusFactory::ID_BLOCKED)
    {

        if (! $this->hasValue('status')) {
            return false;
        }

        $blocked = (int) $this->get('status');

        return $blocked === $blockedDefaultValue;
    }

    public function searchDeleted(int $deletedDefaultValue = StatusFactory::ID_DELETED)
    {
        if (! $this->hasValue('status')) {
            return false;
        }

        $deleted = (int) $this->get('status');

        return $deleted === $deletedDefaultValue;
    }

    //config paginate
    public function hasPaginate(): bool
    {
        return $this->paginate;
    }

    public function withPaginate()
    {
        $this->paginate = true;
    }

    public function withoutPaginate()
    {
        $this->paginate = false;
    }

    //config size page
    public function hasSizePage(): bool
    {
        return is_int($this->sizePage);
    }

    public function withSizePage(int $sizePage)
    {
        $this->sizePage = $sizePage;
    }

    public function withoutSizePage()
    {
        $this->sizePage = null;
    }

    public function sizePage(): ?int
    {
        return $this->sizePage;
    }

    //config limit
    public function hasLimit(): bool
    {
        return is_int($this->limit);
    }

    public function withLimit(int $limit)
    {
        $this->limit = $limit;
    }

    public function withoutLimit()
    {
        $this->limit = null;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

    //config order
    public function withOrder(Order $order)
    {
        $this->order = $order;
    }

    public function withoutOrder()
    {
        $this->order = null;
    }

    public function hasOrder ():bool{
        return !is_null($this->order);
    }

    public function order(): ?Order
    {
        return $this->order;
    }
}
