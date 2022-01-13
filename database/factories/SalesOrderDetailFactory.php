<?php

namespace Database\Factories;

use App\Models\SalesOrderDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesOrderDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesOrderDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sales_order_id' => $this->faker->word,
        'inventory_id' => $this->faker->word,
        'inventory_name' => $this->faker->word,
        'qty' => $this->faker->randomDigitNotNull,
        'uom' => $this->faker->word,
        'unit_price' => $this->faker->randomDigitNotNull,
        'amount' => $this->faker->randomDigitNotNull,
        'created_by' => $this->faker->word,
        'updated_by' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
