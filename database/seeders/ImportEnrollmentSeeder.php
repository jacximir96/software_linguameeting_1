<?php

namespace Database\Seeders;

use App\Src\UserDomain\Role\Service\RoleChecker;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportEnrollmentSeeder extends Seeder
{



    private ImportStudentAction $importStudentAction;

    private RoleChecker $roleChecker;

    public function run()
    {
        $this->importStudentAction = new ImportStudentAction();

        $this->roleChecker = new RoleChecker();

        DB::beginTransaction();

        //procesar cada uno de los importados
        $users = User::with('roles')->orderBy('id', 'asc')->get();

        foreach ($users as $user){

            $rol = $user->rol();

            if (is_null($rol)){
                dd($rol, $user);
            }
            if ($this->roleChecker->isStudent($rol)){
                $this->importStudentAction->handle($user);
            }
        }

        DB::commit();
    }
}
