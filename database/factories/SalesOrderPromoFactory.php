<?php

namespace Database\Factories;

use App\Models\SalesOrderPromo;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesOrderPromoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesOrderPromo::class;

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
        'order_amount' => $this->faker->word,
        'tax' => $this->faker->word,
        'order_total' => $this->faker->word,
        'description' => $this->faker->text,
        'status' => $this->faker->word,
        'created_by' => $this->faker->randomDigitNotNull,
        'updapted_by' => $this->faker->randomDigitNotNull,
        'canceled_by' => $this->faker->randomDigitNotNull,
        'canceled_at' => $this->faker->word,
        'submitted_by' => $this->faker->randomDigitNotNull,
        'submitted_at' => $this->faker->word,
        'rejected_by' => $this->faker->randomDigitNotNull,
        'rejected_at' => $this->faker->word,
        'rejected_reason' => $this->faker->text,
        'processed_by' => $this->faker->randomDigitNotNull,
        'processed_at' => $this->faker->word,
        'order_type' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
