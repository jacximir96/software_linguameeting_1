<?php

namespace App\Src\UserDomain\User\Repository;

use App\Src\UserDomain\User\Model\User;

class UserRepository
{
    public static function findTrashed(int $id){
        return User::withTrashed()->find($id);
    }

    public function obtainToSendEmail(array $ids)
    {
        return User::query()
            ->select('id', 'lastname', 'name', 'email')
            ->whereIn('id', $ids)
            ->get();
    }

    public function notificationUsers(){

        $rolesIds = [
            config('linguameeting.user.roles.ids.administrator'),
            config('linguameeting.user.roles.ids.super_admin'),
            config('linguameeting.user.roles.ids.manager'),
        ];

        return User::query()
            ->role($rolesIds)
            ->orderBy('lastname')
            ->orderBy('name')
            ->get();
    }

    public function billingInfoRelations(): array
    {

        return [
            'billingInfo',
            'billingInfo.accountType',
            'billingInfo.country',
            'billingInfo.currency',
            'billingInfo.methodPayment',
            'invoice',
            'invoice.detail',
        ];
    }
}
