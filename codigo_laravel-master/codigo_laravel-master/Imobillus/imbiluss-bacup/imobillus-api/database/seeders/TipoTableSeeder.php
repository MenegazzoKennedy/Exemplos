<?php

namespace Database\Seeders;
use App\Models\Tipo;
use Illuminate\Database\Seeder;
class TipoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipo::create([
            'descricao' => 'Casas #',
            'slug' => 'casas',
        ]);
        Tipo::create([
            'descricao' => 'Apartamentos',
            'slug' => 'apartamentos',
        ]);
        Tipo::create([
            'descricao' => 'Loteamentos',
            'slug' => 'loteamentos',
        ]);
        Tipo::create([
            'descricao' => 'Terrenos',
            'slug' => 'terrenos',
        ]);
        Tipo::create([
            'descricao' => 'Luxo',
            'slug' => 'luxo',
        ]);
        Tipo::create([
            'descricao' => 'Médio Padrão',
            'slug' => 'medio-padrao',
        ]);
        Tipo::create([
            'descricao' => 'Alto Padrão',
            'slug' => 'alto-padrao',
        ]);
        Tipo::create([
            'descricao' => 'Programa Casa Verde e Amarela',
            'slug' => 'programa-casa-ver-e-amarela',
        ]);
        Tipo::create([
            'descricao' => 'Coberturas',
            'slug' => 'coberturas',
        ]);
        Tipo::create([
            'descricao' => 'Garden e Varandas',
            'slug' => 'garden-e-varandas',
        ]);
        Tipo::create([
            'descricao' => '3 Dormitórios',
            'slug' => '3-dormitorios',
        ]);
        Tipo::create([
            'descricao' => '2 Dormitórios',
            'slug' => '2-dormitorios',
        ]);
        Tipo::create([
            'descricao' => 'Suítes',
            'slug' => 'suites',
        ]);
        Tipo::create([
            'descricao' => 'Loft',
            'slug' => 'loft',
        ]);
        Tipo::create([
            'descricao' => 'Próximos ao Centro',
            'slug' => 'proximos-ao-centro',
        ]);
        Tipo::create([
            'descricao' => 'Próximos a Escolas',
            'slug' => 'proximos-a-escola',
        ]);
        Tipo::create([
            'descricao' => 'Próximos a Universidades',
            'slug' => 'proximos-a-universidades',
        ]);
        Tipo::create([
            'descricao' => 'Super Tipo',
            'slug' => 'super-tipo',
        ]);
        Tipo::create([
            'descricao' => 'Novo Tipo',
            'slug' => 'novo-tipo',
        ]);
    }
}
