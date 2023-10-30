<?php

namespace Database\Seeders;
use App\Models\Documento;
use Illuminate\Database\Seeder;

class DocumentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $produtos = new Documento();
        $imagem = url("../../img/avatar.png");
        Documento::create([
            'descricao' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            'url_modelo' => $imagem,
            'documento' => $imagem,
        ]);
    }
}
