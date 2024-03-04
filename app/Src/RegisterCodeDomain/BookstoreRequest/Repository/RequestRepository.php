<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Repository;

use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\Shared\Service\CriteriaSearch;

class RequestRepository
{
    public function search(CriteriaSearch $criteria)
    {
        $query = BookstoreRequest::query()->with([
            'conversationPackage',
            'file',
            'university',
        ]);

        if ($criteria->searchBy('university_id')) {
            $query->where('university_id', $criteria->get('university_id'));
        }

        return $query->orderBy('date_request', 'desc')->paginate(config('linguameeting.items_per_page'));
    }

    public function eagerLoading(BookstoreRequest $request)
    {
        $request->load([
            'code',
            'code.payment',
            'code.payment.payer',
            'conversationPackage',
            'file',
            'university']
        );
    }
}
