<?php

namespace Database\Seeders;

use App\Src\_Old\Model\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ImportRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemsOld = Roles::orderBy('id_rol', 'asc')->get();

        foreach ($itemsOld as $itemOld){
            Role::create(['name' => $itemOld->name]);
        }
    }
}
