<?php

namespace Database\Factories;

use App\Models\CustomerFirstOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFirstOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerFirstOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_code' => $this->faker->word,
        'first_order_number' => $this->faker->word,
        'first_order_date' => $this->faker->word,
        'created_by' => $this->faker->randomDigitNotNull,
        'updated_by' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
