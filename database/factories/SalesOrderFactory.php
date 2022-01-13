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
        'customer_id' => $this->faker->word,
        'order_date' => $this->faker->word,
        'delivery_date' => $this->faker->word,
        'order_qty' => $this->faker->randomDigitNotNull,
        'tax' => $this->faker->randomDigitNotNull,
        'description' => $this->faker->text,
        'created_by' => $this->faker->word,
        'updated_by' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
