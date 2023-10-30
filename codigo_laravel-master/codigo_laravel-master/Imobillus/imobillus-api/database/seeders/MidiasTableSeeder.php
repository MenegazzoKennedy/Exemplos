<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Midia;
use App\Models\Produto;
use Illuminate\Routing\UrlGenerator;

class MidiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $produtos = Produto::all();
        $imagem = url("../../img/avatar.png");
        foreach($produtos as $produto){
            Midia::create([
                'produto_id' => $produto->id,
                'url_midia' => $imagem,
                'is_destaque' => 0,
            ]);
        }
    }
}
