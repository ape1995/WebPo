<?php

namespace Database\Factories;

use App\Models\CustomerMinOrderHist;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerMinOrderHistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerMinOrderHist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_code' => $this->faker->word,
        'old_price' => $this->faker->randomDigitNotNull,
        'new_price' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
