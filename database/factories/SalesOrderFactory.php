<?php

namespace Database\Factories;

use App\Models\SalesOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_nbr' => $this->faker->word,
            'customer_id' => 1064,
            'order_date' => "2022-01-20",
            'delivery_date' => "2022-01-20",
            'order_qty' => $this->faker->randomDigitNotNull,
            'order_amount' => $this->faker->randomDigitNotNull,
            'tax' => $this->faker->randomDigitNotNull,
            'order_total' => $this->faker->randomDigitNotNull,
            'description' => $this->faker->text,
            'status' => "P",
            'created_by' => 4,
            'updated_by' => 4,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
    }
}
