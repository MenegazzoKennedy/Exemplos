<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caracteristica;

class CaracteristicasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'Area Útil',
            'icone' => null,
            'valor' => '500',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 2,
            'descricao' => 'Area Útil',
            'icone' => null,
            'valor' => '150',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 2,
            'descricao' => 'Area Útil',
            'icone' => null,
            'valor' => '50',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 4,
            'descricao' => 'Area Útil',
            'icone' => null,
            'valor' => '1500',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);


        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'Areal',
            'icone' => null,
            'valor' => '25',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 2,
            'descricao' => 'Areal',
            'icone' => null,
            'valor' => '25',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 3,
            'descricao' => 'Areal',
            'icone' => null,
            'valor' => '25',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 4,
            'descricao' => 'Areal',
            'icone' => null,
            'valor' => '25',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);

        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'Banheiros',
            'icone' => null,
            'valor' => '2',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 2,
            'descricao' => 'Banheiros',
            'icone' => null,
            'valor' => '2',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 3,
            'descricao' => 'Banheiros',
            'icone' => null,
            'valor' => '2',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 4,
            'descricao' => 'Banheiros',
            'icone' => null,
            'valor' => '20',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);

        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'Garagem',
            'icone' => null,
            'valor' => '1',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 2,
            'descricao' => 'Garagem',
            'icone' => null,
            'valor' => '3',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 3,
            'descricao' => 'Garagem',
            'icone' => null,
            'valor' => '1',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 4,
            'descricao' => 'Garagem',
            'icone' => null,
            'valor' => '5',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);


        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'Guapimirim',
            'icone' => null,
            'valor' => '13',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 2,
            'descricao' => 'Guapimirim',
            'icone' => null,
            'valor' => '13',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 3,
            'descricao' => 'Guapimirim',
            'icone' => null,
            'valor' => '13',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 4,
            'descricao' => 'Guapimirim',
            'icone' => null,
            'valor' => '13',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);


        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'latitude',
            'icone' => null,
            'valor' => '-20.4536103',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);


        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'Lavanderia',
            'icone' => null,
            'valor' => '5',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 2,
            'descricao' => 'Lavanderia',
            'icone' => null,
            'valor' => '1',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 3,
            'descricao' => 'Lavanderia',
            'icone' => null,
            'valor' => '3',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 4,
            'descricao' => 'Lavanderia',
            'icone' => null,
            'valor' => '3',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);


        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'longitude',
            'icone' => null,
            'valor' => '-54.6550954',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);


        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'Magé',
            'icone' => null,
            'valor' => '28',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 2,
            'descricao' => 'Magé',
            'icone' => null,
            'valor' => '28',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 3,
            'descricao' => 'Magé',
            'icone' => null,
            'valor' => '28',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 4,
            'descricao' => 'Magé',
            'icone' => null,
            'valor' => '28',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);


        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'Petrópolis',
            'icone' => null,
            'valor' => '24',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 2,
            'descricao' => 'Petrópolis',
            'icone' => null,
            'valor' => '24',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 3,
            'descricao' => 'Petrópolis',
            'icone' => null,
            'valor' => '24',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 4,
            'descricao' => 'Petrópolis',
            'icone' => null,
            'valor' => '24',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);


        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'Quartos',
            'icone' => null,
            'valor' => '3',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 2,
            'descricao' => 'Quartos',
            'icone' => null,
            'valor' => '6',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 3,
            'descricao' => 'Quartos',
            'icone' => null,
            'valor' => '5',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 4,
            'descricao' => 'Quartos',
            'icone' => null,
            'valor' => '10',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);


        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'Rio De Janeiro',
            'icone' => null,
            'valor' => '60',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 2,
            'descricao' => 'Rio De Janeiro',
            'icone' => null,
            'valor' => '60',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 3,
            'descricao' => 'Rio De Janeiro',
            'icone' => null,
            'valor' => '60',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 4,
            'descricao' => 'Rio De Janeiro',
            'icone' => null,
            'valor' => '60',
            'is_coord' => 1,
            'quantidade' => 0,
        ]);


        Caracteristica::create([
            'produto_id' => 1,
            'descricao' => 'Suítes',
            'icone' => null,
            'valor' => '3',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 2,
            'descricao' => 'Suítes',
            'icone' => null,
            'valor' => '2',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 3,
            'descricao' => 'Suítes',
            'icone' => null,
            'valor' => '2',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
        Caracteristica::create([
            'produto_id' => 4,
            'descricao' => 'Suítes',
            'icone' => null,
            'valor' => '10',
            'is_coord' => 0,
            'quantidade' => 0,
        ]);
    }
}
