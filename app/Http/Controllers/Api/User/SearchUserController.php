<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\UserDomain\User\Model\User;
use App\Src\UserDomain\User\Request\SearchAutocompleteRequest;
use Illuminate\Support\Facades\Log;


class SearchUserController extends Controller
{
    public function searchForAutocomplete(SearchAutocompleteRequest $request)
    {
        try {


            $users = User::query()
                ->where('name', 'LIKE', '%'.$request->search.'%')
                ->orWhere('lastname', 'LIKE', '%'.$request->search.'%')
                ->orderBy('lastname')
                ->orderBy('name')
                ->limit(10)
                ->get();

            $response = [];
            foreach ($users as $user){
                $item = [
                    'id' => $user->id,
                    'text' => $user->full_name,
                    ];
                $response[] = $item;
            }

            return response()->json(['results' => $response]);

        } catch (\Throwable $exception) {
            Log::error('There is an error when search users for autocomplete.', [
                'exception' => $exception,
            ]);

            return response('', 500);
        }
    }
}
