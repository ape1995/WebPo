<?php

namespace Database\Factories;

use App\Models\BundlingProductFree;
use Illuminate\Database\Eloquent\Factories\Factory;

class BundlingProductFreeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BundlingProductFree::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'bundling_product_id' => $this->faker->randomDigitNotNull,
        'product_code' => $this->faker->word,
        'qty' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
