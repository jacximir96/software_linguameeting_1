<?php
namespace App\Src\CourseDomain\Course\Model\Trait;


trait AuditTrait
{

    public function hasAudits(): bool
    {
        return (bool) $this->audits()->count();
    }

    public function latestUpdater(): string
    {

        $lastUpdate = $this->audits()->latest()->first();

        if ($lastUpdate) {
            return $lastUpdate->user->writeFullName();
        }

        return 'Without Data';

    }

}
