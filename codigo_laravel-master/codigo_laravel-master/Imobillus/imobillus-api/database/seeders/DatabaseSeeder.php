<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            UserTableSeeder::class,
            CorretorTableSeeder::class,
            TipoTableSeeder::class,
            EstadosTableSeeder::class,
            CidadesTableSeeder::class,
            BairrosTableSeeder::class,
            //ProdutoTableSeeder::class,
            //CaracteristicasTableSeeder::class,
            //ClienteTableSeeder::class,
            RegioesTableSeeder::class,
            //MidiasTableSeeder::class,
            //DocumentoTableSeeder::class,
            //NegociacaoTableSeeder::class,
        ]);
    }
}
