<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::create([
            'user_id' => 2,
            'corretor_id_preferido' => 1,
            'cpf' => '999999999',
            'nascimento' => '2000-01-01',
            'genero' => 1,
            'url_foto' => 'teste',
            'telefone' => '999999999',
            'status' => 1,
        ]);
        Cliente::create([
            'user_id' => 3,
            'corretor_id_preferido' => 2,
            'cpf' => '999999999',
            'nascimento' => '2000-01-01',
            'genero' => 1,
            'url_foto' => 'teste',
            'telefone' => '999999999',
            'status' => 1,
        ]);
        Cliente::create([
            'user_id' => 4,
            'corretor_id_preferido' => 3,
            'cpf' => '999999999',
            'nascimento' => '2000-01-01',
            'genero' => 1,
            'url_foto' => 'teste',
            'telefone' => '999999999',
            'status' => 1,
        ]);
    }
}
