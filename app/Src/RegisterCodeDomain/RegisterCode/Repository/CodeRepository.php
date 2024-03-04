<?php

namespace App\Src\RegisterCodeDomain\RegisterCode\Repository;

use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\RegisterCodeDomain\RegisterCode\Model\KeyCode;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\Shared\Repository\BuilderRepository;
use App\Src\Shared\Service\CriteriaSearch;

class CodeRepository
{
    private BuilderRepository $builderRepository;

    public function __construct(BuilderRepository $builderRepository)
    {

        $this->builderRepository = $builderRepository;
    }

    public function obtainCodesForIndex()
    {
        return RegisterCode::with($this->relations())
            ->orderBy('id', 'desc')
            ->paginate(config('linguameeting.items_per_page'));
    }

    public function checkCodeExists(KeyCode $keyCode): bool
    {
        return (bool) RegisterCode::where('code', $keyCode->get())->count();
    }

    public function findByCode(KeyCode $keyCode)
    {
        return RegisterCode::where('code', $keyCode->get())->first();
    }

    public function hasRequestCodeUsed(BookstoreRequest $request)
    {
        return (bool) $this->countRequestCodeUsed($request);
    }

    public function countRequestCodeUsed(BookstoreRequest $request)
    {
        return RegisterCode::query()
            ->where('bookstore_request_id', $request->id)
            ->where('is_used', 1)
            ->count();
    }

    public function countRequestCodeDeleted(BookstoreRequest $request)
    {
        return RegisterCode::query()
            ->where('bookstore_request_id', $request->id)
            ->onlyTrashed()
            ->count();
    }

    public function search(CriteriaSearch $criteria)
    {
        $query = RegisterCode::query()->with($this->relations());

        if ($criteria->searchBy('code')) {
            $query->where('code', 'LIKE', '%'.$criteria->get('code').'%');
        }

        if ($criteria->searchBy('code_university_id')) {
            $query->whereHas('request', function ($query) use ($criteria) {
                $query->where('university_id', $criteria->get('code_university_id'));
            });
        }

        if ($criteria->searchBy('bookstore_request_id')) {
            $query->where('bookstore_request_id', $criteria->get('bookstore_request_id'));
        }

        if ($criteria->hasOrder()){
            $query->orderBy($criteria->order()->field(), $criteria->order()->type());
        }
        else{
            $query = $query->orderBy('id', 'desc');
        }

        if ($criteria->hasPaginate()){
            return $query->paginate(config('linguameeting.items_per_page'));
        }

        return $query->get();
    }

    public function searchIndividual(CriteriaSearch $criteria, OrderListing $orderListing)
    {
        $query = RegisterCode::query()
            ->with($this->relations());

        $query = $this->builderRepository->buildSimpleWhereLike($query, $criteria, 'code');
        $query->orderBy('id', 'desc');

        return $query->paginate(config('linguameeting.items_per_page'));
    }

    public function relations(): array
    {
        return [
            'payment',
            'payment.payer',
            'payment.refund',
            'payment.payer',
            'payment.publicPayer',
            'payment.refund',
            'payment.detail',
            'payment.detail.payable',
            /*
            'payment.enrollment.section',
            'payment.enrollment.section.course',
            'payment.enrollment.section.course.university',
            'payment.enrollment.user',
            */
            'request',
            'request.university',
        ];
    }
}
