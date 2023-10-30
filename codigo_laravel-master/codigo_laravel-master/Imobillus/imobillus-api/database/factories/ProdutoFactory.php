<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Produto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'logradouro' => $this->faker->streetName(),
            'numero' => $this->faker->numberBetween($min = 1, $max = 9000),
            'descricao' => $this->faker->text(),
            'valor' => $this->faker->numberBetween($min = 100000, $max = 15000000),
            'slug' => $this->faker->text(),
            'titulo' => $this->faker->text(),
            'detalhes' => $this->faker->text(),
            'destaque' => 1,
            'bairro_id' => 6255,
            'cep' => $this->faker->numberBetween($min = 100000, $max = 15000000),
        ];
    }
}
