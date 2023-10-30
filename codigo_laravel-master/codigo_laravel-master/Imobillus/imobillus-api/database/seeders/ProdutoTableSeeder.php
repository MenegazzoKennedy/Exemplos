<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProdutoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Produto::factory()
            ->count(50)
            ->create()
            ->each(function($c) {
                $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]);
                $c->tipos()->attach([$collection->random(),$collection->random(),$collection->random()]);
            });
    }
}
