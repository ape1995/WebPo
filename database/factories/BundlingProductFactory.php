<?php

namespace Database\Factories;

use App\Models\BundlingProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class BundlingProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BundlingProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'start_date' => $this->faker->word,
        'end_date' => $this->faker->word,
        'product_code' => $this->faker->word,
        'qty' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
