<?php


namespace App\Http\Controllers\User;


use App\Src\Shared\Model\ValueObject\Id;
use App\Src\Shared\Repository\SearchRepository;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\Shared\Service\IdCollection;
use App\Src\UserDomain\User\Request\SendEmailRequest;

trait MailableController
{

    protected function configParameters()
    {

        $usersIds = collect();
        if (request()->filled('users_ids')) {
            $usersIds = collect(request()->users_ids);
        }

        $usersFilters = http_build_query(request()->all());

        view()->share([
            'usersFilters' => $usersFilters,
            'usersIds' => $usersIds,
        ]);
    }

    protected function obtainIdsCollection(SendEmailRequest $request, SearchRepository $searchRepository): ?IdCollection
    {

        if ($request->filled('users_ids')) {
            return $request->buildIdsCollection();
        }

        if ($request->filled('users_filters')) {

            $model = [];
            parse_str(request()->users_filters, $model);

            $criteria = new CriteriaSearch($model);
            $criteria->withoutPaginate();

            $orderListing = $this->obtainOrderListing('lastname');

            $idsCollection = new IdCollection();
            $searchRepository->search($criteria, $orderListing)->each(function ($user) use ($idsCollection) {
                $id = new Id($user->id);
                $idsCollection->add($id);
            });

            return $idsCollection;
        }

        return null;

    }
}
