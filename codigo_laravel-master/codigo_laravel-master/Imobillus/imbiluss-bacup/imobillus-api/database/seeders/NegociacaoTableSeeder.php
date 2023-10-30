<?php

namespace Database\Seeders;
use App\Models\Negociacao;
use App\Enums\NegociacaoStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NegociacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = NegociacaoStatus::getKeys();
        Negociacao::create([
            'imovel_id' => 1,
            'corretor_id' => 1,
            'cliente_id' => 1,
            'status' => $status[array_rand($status, 1)],
        ])->documentos()->attach(1);
        Negociacao::create([
            'imovel_id' => 2,
            'corretor_id' => 2,
            'cliente_id' => 2,
            'status' => $status[array_rand($status, 1)],
        ])->documentos()->attach(1);
        Negociacao::create([
            'imovel_id' => 3,
            'corretor_id' => 3,
            'cliente_id' => 3,
            'status' => $status[array_rand($status, 1)],
        ])->documentos()->attach(1);
        
        Negociacao::create([
            'imovel_id' => 1,
            'corretor_id' => 2,
            'cliente_id' => 2,
            'status' => $status[array_rand($status, 1)],
        ])->documentos()->attach(1);
        Negociacao::create([
            'imovel_id' => 1,
            'corretor_id' => 2,
            'cliente_id' => 3,
            'status' => $status[array_rand($status, 1)],
        ])->documentos()->attach(1);
        Negociacao::create([
            'imovel_id' => 1,
            'corretor_id' => 3,
            'cliente_id' => 3,
            'status' => $status[array_rand($status, 1)],
        ])->documentos()->attach(1);
        
        Negociacao::create([
            'imovel_id' => 4,
            'corretor_id' => 2,
            'cliente_id' => 2,
            'status' => $status[array_rand($status, 1)],
        ])->documentos()->attach(1);
        Negociacao::create([
            'imovel_id' => 4,
            'corretor_id' => 2,
            'cliente_id' => 2,
            'status' => $status[array_rand($status, 1)],
        ])->documentos()->attach(1);
        Negociacao::create([
            'imovel_id' => 4,
            'corretor_id' => 3,
            'cliente_id' => 3,
            'status' => $status[array_rand($status, 1)],
        ])->documentos()->attach(1);
        
        Negociacao::create([
            'imovel_id' => 5,
            'corretor_id' => 2,
            'cliente_id' => 2,
            'status' => $status[array_rand($status, 1)],
        ])->documentos()->attach(1);
        Negociacao::create([
            'imovel_id' => 5,
            'corretor_id' => 3,
            'cliente_id' => 3,
            'status' => $status[array_rand($status, 1)],
        ])->documentos()->attach(1);
    }
}
