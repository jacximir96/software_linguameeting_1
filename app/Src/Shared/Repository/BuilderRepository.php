<?php

namespace App\Src\Shared\Repository;

use App\Src\Shared\Service\CriteriaSearch;
use Illuminate\Database\Eloquent\Builder;

class BuilderRepository
{
    public function buildSimpleWhere(Builder $query, CriteriaSearch $criteria, ...$fields): Builder
    {
        foreach ($fields as $field) {
            if ($criteria->searchBy($field)) {
                $query->where($field, $criteria->get($field));
            }
        }

        return $query;
    }

    public function buildSimpleWhereLike(Builder $query, CriteriaSearch $criteria, ...$fields): Builder
    {
        foreach ($fields as $field) {
            if ($criteria->searchBy($field)) {
                $query->where($field, 'LIKE', '%'.$criteria->get($field).'%');
            }
        }

        return $query;
    }

    public function buildWhereByUserLanguage(Builder $query, CriteriaSearch $criteria): Builder
    {
        if ($criteria->searchBy('language_id')) {
            $query->whereHas('language', function ($query) use ($criteria) {
                $query->where('language.id', $criteria->get('language_id'));
            });
        }

        return $query;
    }

    public function buildWhereByUserStatus(Builder $query, CriteriaSearch $criteria): Builder
    {

        if ($criteria->searchBy('status')) {
            if ($criteria->searchActive()) {
                $query->where('active', '=', 1);
            } elseif ($criteria->searchDeactivated()) {
                $query->where('active', '=', 0);
            } elseif ($criteria->searchDeleted()) {
                $query->onlyTrashed();
            } elseif ($criteria->searchBlocked()) {
                $query->where('locked', '=', 1);
            }
        } else {
            $query->where('active', '=', 1);
        }

        return $query;
    }

    public function buildWhereByRol(Builder $query, CriteriaSearch $criteria, int|array $defaultRoleId): Builder
    {

        if ($criteria->searchBy('role_id')) {
            $query->role($criteria->get('role_id'));
        } else {
            $query->role($defaultRoleId);
        }

        return $query;
    }

    public function convertTimezone(Builder $query, string $fieldToConvert)
    {

    }
}
