<?php

namespace Database\Seeders;

use App\Models\Corretor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CorretorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Corretor::create([
            'user_id' => 5,
            'url_foto' => 'imagem',
            'creci' => '999999999',
            'genero' => 1,
            'banco' => 'CAIXA',
            'agencia' => '9999999',
            'tipo_conta' => 1,
            'pix' => '9999999',
            'biografia' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        ]);
        Corretor::create([
            'user_id' => 6,
            'url_foto' => 'imagem',
            'creci' => '999999999',
            'genero' => 1,
            'banco' => 'CAIXA',
            'agencia' => '9999999',
            'tipo_conta' => 1,
            'pix' => '9999999',
            'biografia' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        ]);
        Corretor::create([
            'user_id' => 7,
            'url_foto' => 'imagem',
            'creci' => '999999999',
            'genero' => 1,
            'banco' => 'CAIXA',
            'agencia' => '9999999',
            'tipo_conta' => 1,
            'pix' => '9999999',
            'biografia' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        ]);
    }
}
