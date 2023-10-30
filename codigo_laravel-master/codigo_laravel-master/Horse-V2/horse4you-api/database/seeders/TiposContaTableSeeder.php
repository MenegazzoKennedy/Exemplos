<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class TiposContaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Pessoal']);
        Role::create(['name' => 'Profisional']);
        Role::create(['name' => 'Empresarial']);
    }

}
