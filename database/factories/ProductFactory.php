<?php

namespace Database\Factories;

use App\Domain\Product\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('pt_BR');
        return [
            'name' => $this->faker->name(),
            'symbol' => Str::random(5),
            'product_type_id' => 1,
            'company_name' => $this->faker->name(),
            'document' => $faker->cnpj,
            'description' => Str::random(100),
        ];
    }
}
