<?php
namespace App\Http\Controllers\Auth\University;

use App\Http\Controllers\Controller;
use App\Src\UniversityDomain\University\Action\CreateUniversityFromPublicAction;
use App\Src\UniversityDomain\University\Request\PublicRegisterRequest;
use Illuminate\Support\Facades\DB;


//Llamado desde ajax en la parte pública al crear un instructor y crear nueva universidad.
class RegisterController extends Controller
{
    public function __invoke (PublicRegisterRequest $request){

        try{

            //dump($request->all(), request()->all());

            DB::beginTransaction();

            $action = app(CreateUniversityFromPublicAction::class);
            $university = $action->handle($request);

            return response()->json([
                'id' => $university->id,
                'name' => $university->name,
            ], 200);

        }

        catch (\Throwable $exception){

            DB::rollBack();

            return response()->json('Error creating university.', 500);
        }
    }
}
