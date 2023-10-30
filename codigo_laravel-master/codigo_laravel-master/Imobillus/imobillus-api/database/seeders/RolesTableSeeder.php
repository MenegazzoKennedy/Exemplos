<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'cliente']);
        Role::create(['name' => 'corretor']);
        Role::create(['name' => 'construtora']);
        Role::create(['name' => 'gestor_regional']);
    }
}
