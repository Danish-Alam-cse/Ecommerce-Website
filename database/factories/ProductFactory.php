<?php

namespace Database\Factories;

use App\Models\product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'price' => $this->faker->numberBetween(100,800),
            'unit' => 'plate',
            'isVeg' => $this->faker->boolean,
            'image' => 'pro.png'
        ];
    }
}
